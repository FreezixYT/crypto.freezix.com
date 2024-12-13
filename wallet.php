<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: connection.php');
    exit();
}

$user = $_SESSION['user'];
$walletFile = './data/wallet.json';
$cryptoFile = './data/crypto.json';

if (file_exists($walletFile)) {
    $wallets = json_decode(file_get_contents($walletFile), true);
} else {
    echo "Erreur, fichier non trouvé";
}

if (file_exists($cryptoFile)) {
    $cryptoData = json_decode(file_get_contents($cryptoFile), true);
} else {
    echo "Erreur, fichier non trouvé";
}

if (!($wallets[$user])) 
{
    $userWallet = $wallets[$user];
} else {
    echo "Erreur, le portefeuille de l'utilisateur n'existe pas.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Cryptos | Freezix.com</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/assets.css">
    <link rel="stylesheet" href="./css/wallet.css">
</head>

<body>

    <?php include "./assets/header.html"; ?>

    <main>
        <h1>Mes Cryptomonnaies</h1>

        <div class="zone-crypto">
            <?php
            if (!empty($userWallet)) {
                foreach ($userWallet as $cryptoID => $amount) {
                    if (isset($cryptoData[$cryptoID])) {
                        echo '<div class="crypto-item">';
                        echo '<img src="' . $cryptoData[$cryptoID]['image'] . '" alt="' . $cryptoData[$cryptoID]['name'] . '">';
                        echo '<p><strong>' . $cryptoData[$cryptoID]['name'] . '</strong></p>';
                        echo '<p>Quantité : ' . $amount . '</p>';
                        echo '</div>';
                    }
                }
            } else {
                echo '<p>Vous n\'avez aucune crypto pour le moment.</p>';
            }
            ?>
        </div>

        <p>Freezix.com - Regardez, achetez et vendez vos cryptos au meilleur prix.</p>

    </main>

    <?php include "./assets/footer.html"; ?>

</body>
</html>
