<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: connection.php');
    exit();
}

$user = $_SESSION['user'];
foreach ($user as $valu) {
    $username = $valu;
}

$walletFile = './data/wallet.json';

$apiUrl = "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,dogecoin,shiba-inu,solana&vs_currencies=usd";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

$prices = $response ? json_decode($response, true) : [];

$freezixUrl = "https://freezix.com/api/";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $freezixUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$freezixResponse = curl_exec($curl);
curl_close($curl);

$freezixPrice = $freezixResponse;

$cryptos = [
    "Bitcoin" => "bitcoin",
    "Ethereum" => "ethereum",
    "Dogecoin" => "dogecoin",
    "Shiba Inu" => "shiba-inu",
    "Solana" => "solana",
    "FreezixCoin" => "freezixcoin"
];

$wallets = file_exists($walletFile) ? json_decode(file_get_contents($walletFile), true) : [];
$userWallet = $wallets[$username] ?? [
    "Bitcoin" => 0,
    "Ethereum" => 0,
    "Dogecoin" => 0,
    "Freezixcoin" => 0,
    "Shiba Inu" => 0,
    "Solana" => 0
];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/assets.css">
    <link rel="stylesheet" href="./css/market.css">
    <title>Marché des Cryptos</title>
</head>

<body>
    <?php include 'assets/header.html'; ?>

    <main>
        <h1>Marché des Cryptomonnaies</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="zone-crypto">
            <?php foreach ($cryptos as $name => $id): ?>
                <?php 
                $price = ($id === "freezixcoin") ? $freezixPrice : ($prices[$id]['usd'] ?? 'Non disponible');
                $quantity = $userWallet[$name] ?? 0;
                ?>
                <div class="crypto">
                    <p><strong><?php echo $name; ?> :</strong> <?php echo is_numeric($price) ? "$" . $price : $price; ?></p>
                    <p>Quantité possédée : <?php echo $quantity; ?></p>
                    <div class="actions">
                        <form action="transaction.php" method="POST" class="transaction-form">
                            <input type="hidden" name="action" value="buy">
                            <input type="hidden" name="crypto" value="<?php echo $id; ?>">
                            <label>
                                Quantité :
                                <input type="number" name="quantity" min="1" required>
                            </label>
                            <button class="btn-achter" type="submit">Acheter</button>
                        </form>
                        <form action="transaction.php" method="POST" class="transaction-form">
                            <input type="hidden" name="action" value="sell">
                            <input type="hidden" name="crypto" value="<?php echo $id; ?>">
                            <label>
                                Quantité :
                                <input type="number" name="quantity" min="1" max="<?php echo $quantity; ?>" required>
                            </label>
                            <button class="btn-vendre" type="submit">Vendre</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <?php include "./assets/footer.html"; ?>
</body>

</html>
