<?php
// URL de l'API pour récupérer les prix
$apiUrl = "//https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,dogecoin&vs_currencies=usd";

// Initialisation de cURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Exécution de la requête
$response = curl_exec($curl);
curl_close($curl);

// Vérification de la réponse
if ($response) {
    $prices = json_decode($response, true);

    // Extraction des prix
    $bitcoinPrice = $prices['bitcoin']['usd'] ?? 'Non disponible';
    $ethereumPrice = $prices['ethereum']['usd'] ?? 'Non disponible';
    $dogecoinPrice = $prices['dogecoin']['usd'] ?? 'Non disponible';
} else {
    $bitcoinPrice = $ethereumPrice = $dogecoinPrice = 'Erreur API';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/assets.css">
    <title>Prix des Cryptomonnaies</title>
</head>
<body>
    <?php include 'assets/header.html'; ?>
    <h1>Prix des Cryptomonnaies</h1>
    <div class="crypto">
        <strong>Bitcoin (BTC) :</strong> $<?php echo $bitcoinPrice; ?>
    </div>
    <div class="crypto">
        <strong>Ethereum (ETH) :</strong> $<?php echo $ethereumPrice; ?>
    </div>
    <div class="crypto">
        <strong>Dogecoin (DOGE) :</strong> $<?php echo $dogecoinPrice; ?>
    </div>

</body>
</html>
