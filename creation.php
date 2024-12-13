<?php
$nom = "";
$prenom = "";
$email = "";
$mdp = "";
$mdp2 = "";
$date_creation = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = htmlspecialchars($_POST['mdp']);
    $mdp2 = htmlspecialchars($_POST['mdp2']);
    $date_creation = date('Y-m-d H:i:s');

    if ($mdp !== $mdp2) 
    {
        echo "<p style='color: red;'>Erreur : Les mots de passe ne correspondent pas.</p>";
    } 
    else 
    {
        $fichierJSON = './data/user.json';
        $utilisateurs = [];

        if (file_exists($fichierJSON)) {
            $contenu = file_get_contents($fichierJSON);
            $utilisateurs = json_decode($contenu, true); 
        }
        $emailExistant = false;
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur['email'] === $email) {
                $emailExistant = true;
                break;
            }
        }

        if ($emailExistant) {
            echo "<p style='color: red;'>Erreur : Cet email est déjà utilisé.</p>";
        } 
        else 
        {
            $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);

            $nouvelUtilisateur = [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'mdp' => $mdpHash,
                'date_creation' => $date_creation,
            ];

            $utilisateurs[] = $nouvelUtilisateur;

            file_put_contents($fichierJSON, json_encode($utilisateurs, JSON_PRETTY_PRINT));
            header('Location: connection.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/assets.css">
    <link rel="stylesheet" href="./css/formulair.css">
    <title>Crée un compte | Freezix.com</title>
</head>

<body>
    <?php include 'assets/header.html'; ?>
    <h1>Crée un compte</h1>
    <form method="post" action="">
        <label>Nom</label>
        <input name="nom" type="text" required>
        <br>
        <label>Prénom</label>
        <input name="prenom" type="text" required>
        <br>
        <label>Email</label>
        <input name="email" type="email" required>
        <br>
        <label>Mot de passe</label>
        <input name="mdp" type="password" required>
        <br>
        <label>Confirmation mot de passe</label>
        <input name="mdp2" type="password" required>
        <br>
        <input type="submit" value="Créer un compte">
        <br>
        <a href="connection.php">Se connecter</a>
    </form>
    <?php include 'assets/footer.html'; ?>
</body>

</html>
