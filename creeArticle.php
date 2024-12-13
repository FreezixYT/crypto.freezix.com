<?php
session_start();

if (!isset($_SESSION['user'])) 
{
    header('Location: connection.php');
    exit();
}

$titre = "";
$contenu = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST["titre"]);
    $contenu = htmlspecialchars($_POST["contenu"]);

    $dt = time();
    $date = date("d/m/Y H:i:s", $dt);

    $data = array(
        "date" => $date,
        "creator" => $_SESSION["user"],
        "titre" => $titre,
        "article" => $contenu
    );

    $filename = "data/actu.json";

    if (file_exists($filename)) 
    {
        $jsonData = file_get_contents($filename);
        $dataArray = json_decode($jsonData, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $dataArray[] = $data;
        } else {
            echo "Erreur de décodage JSON.";
            exit();
        }
    } else {
        $dataArray = array();
        $dataArray[] = $data;
    }

    $newJsonData = json_encode($dataArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    file_put_contents($filename, $newJsonData);

    header('Location: actu.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Article | Freezix</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/assets.css">
    <link rel="stylesheet" href="css/formulair.css">
</head>
<body>

    <?php include "./assets/header.html"; ?>

    <main>
        <h1>Créer un Article</h1>

        <form method="POST" action="">
            <label for="titre">Titre</label>
            <input type="text" name="titre" id="titre" placeholder="Entrez le titre" required>

            <label for="contenu">Contenu</label>
            <textarea id="contenu" name="contenu" rows="5" placeholder="Rédigez votre contenu ici..." required></textarea>

            <input type="submit" value="Créer l'article">
        </form>
    </main>

    <?php include "./assets/footer.html"; ?>
    
</body>
</html>
