<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: connection.php');
    exit();
}

$user = $_SESSION['user'];
$walletFile = './data/wallet.json';
$cryptoFile = './data/crypto.json';

$wallets = file_exists($walletFile) ? json_decode(file_get_contents($walletFile), true) : [];
$cryptoData = file_exists($cryptoFile) ? json_decode(file_get_contents($cryptoFile), true) : [];

$userWallet = isset($wallets[$user]) ? $wallets[$user] : [];
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
            <?php if (!empty($userWallet)) : ?>
                <?php foreach ($userWallet as $cryptoID => $amount) : ?>
                    <?php if (isset($cryptoData[$cryptoID])): ?>
                        <div class="crypto-item">
                            <img src="<?= $cryptoData[$cryptoID]['image'] ?>" alt="<?= $cryptoData[$cryptoID]['name'] ?>">
                            <p><strong><?= $cryptoData[$cryptoID]['name'] ?></strong></p>
                            <p>Quantité : <?= $amount ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Vous n'avez aucune crypto pour le moment.</p>
            <?php endif; ?>
        </div>

        <p>Freezix.com - Regardez, achetez et vendez vos cryptos au meilleur prix.</p>

    </main>

    <?php include "./assets/footer.html"; ?>

</body>
</html>
