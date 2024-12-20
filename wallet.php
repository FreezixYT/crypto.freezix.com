<?php
session_start();

if (!isset($_SESSION['user'])) 
{
    header('Location: connection.php');
    exit();
}

$user = $_SESSION['user'];
$email = $user['email'];

$walletFile = './data/wallet.json';
$cryptoFile = './data/crypto.json';

$wallets = json_decode(file_get_contents($walletFile), true);
$cryptoData = json_decode(file_get_contents($cryptoFile), true);

if (isset($wallets[$email])) {
    $userWallet = $wallets[$email];
} else {
    echo "Erreur : Le portefeuille de l'utilisateur n'existe pas.";
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
            $hasCrypto = false; 

            foreach ($userWallet as $cryptoName => $amount) 
            {
                if ($amount > 0) 
                {
                    $hasCrypto = true;
                    $cryptoImage = "";
                    $cryptoDisplayName = $cryptoName; 
                    foreach ($cryptoData as $key => $cryptoInfo) 
                    {
                        if ($cryptoInfo['name'] === $cryptoName) 
                        {
                            $cryptoImage = $cryptoInfo['image'];
                            $cryptoDisplayName = $cryptoInfo['name'];
                            break;
                        }
                    }
                    echo '<div class="crypto-item">';
                    if ($cryptoImage) 
                    {
                        echo '<img src="' . htmlspecialchars($cryptoImage) . '" alt="' . htmlspecialchars($cryptoDisplayName) . '">';
                    }
                    echo '<p><strong>' . htmlspecialchars($cryptoDisplayName) . '</strong></p>';
                    echo '<p>Quantité : ' . htmlspecialchars($amount) . '</p>';
                    echo '</div>';
                }
            }

            if (!$hasCrypto) {
                echo '<p>Vous n\'avez aucune cryptomonnaie avec un montant supérieur à 0.</p>';
            }
            ?>
        </div>

        <p>Freezix.com - Regardez, achetez et vendez vos cryptos au meilleur prix.</p>
    </main>

    <?php include "./assets/footer.html"; ?>
</body>

</html>
