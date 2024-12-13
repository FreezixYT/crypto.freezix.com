<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "mdp", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($email && $password) {
        $fichierJSON = './data/user.json';

        if (file_exists($fichierJSON)) {
            $contenu = file_get_contents($fichierJSON);
            $utilisateurs = json_decode($contenu, true);

            if ($utilisateurs) {
                foreach ($utilisateurs as $utilisateur) {
                    if ($utilisateur['email'] === $email && password_verify($password, $utilisateur['mdp'])) {
                        $_SESSION['user'] = ['email' => $utilisateur['email']];
                        header('Location: index.php');
                        exit();
                    }
                }
            }
            $messageErreur = "Email ou mot de passe incorrect.";
        } else {
            $messageErreur = "Erreur : le fichier des utilisateurs est introuvable.";
        }
    } else {
        $messageErreur = "Veuillez remplir tous les champs.";
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
    <title>Connection | Freezix.com</title>
</head>
<body>
    <?php include 'assets/header.html'; ?>
    <h1>Se connecter</h1>
    <form method="post">
        <label>Email</label>
        <input name="email" type="email" required>
        <br>
        <label>Mot de passe</label>
        <input name="mdp" type="password" required>
        <br>
        <input type="submit" value="Se connecter">
        <br>
        <a href="creation.php">Crée un compte</a>
    </form>
    <?php if (isset($messageErreur)) echo "<p>$messageErreur</p>"; ?>
    <?php include 'assets/footer.html'; ?>
</body>
</html>
