<?php
session_start();
$data = file_get_contents("./data/actu.json");
$actu = json_decode($data, true);

if ($actu === null) {
    $actu = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Bienvenue</title>
    <link rel="icon" href="https://cdn.icon-icons.com/icons2/1385/PNG/512/btc-crypto-cryptocurrency-cryptocurrencies-cash-money-bank-payment_95386.png">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/assets.css">
    <link rel="stylesheet" href="./css/actu.css">
</head>

<body>
    <?php include "./assets/header.html"; ?>

    <main>
        <h1>Actualité</h1>
        <div class="zone-article">
            <?php
            if (!empty($actu)) {
                foreach ($actu as $article) {
                    echo "<div class='article'>";
                    echo "<h2>" . htmlspecialchars($article['titre']) . "</h2>";
                    echo "<p>" . nl2br(htmlspecialchars($article['article'])) . "</p>";
                    echo "<div class='footer-article'>";
                    echo "<span class='date'>Date : " . htmlspecialchars($article['date']) . "</span>";
                    echo "<span class='creator'>Auteur : " . htmlspecialchars($article['creator']['email']) . "</span>";
                    echo "</div>";

                    echo "</div>";
                }
            } else {
                echo "<p>Aucun article trouvé.</p>";
            }
            ?>


        </div>
        <a href="./creeArticle.php" class="more">+</a>
    </main>

    <?php include "./assets/footer.html"; ?>
</body>

</html>