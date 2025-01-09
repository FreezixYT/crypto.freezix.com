<?php
session_start();

// Vérification de la session de l'utilisateur
if (!isset($_SESSION['user'])) {
    header('Location: connection.php');
    exit();
}

$user = $_SESSION['user'];
foreach ($user as $valu) {
    $username = $valu;
}

$walletFile = './data/wallet.json';
$wallets = file_exists($walletFile) ? json_decode(file_get_contents($walletFile), true) : [];

//check si achat ou vente
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $action = $_POST['action'];
    $crypto = $_POST['crypto'];
    $quantity = (int)$_POST['quantity'];

    if ($action === 'buy') {
        //ajouter
        if (!isset($wallets[$username][$crypto])) {
            $wallets[$username][$crypto] = 0; 
        }
        $wallets[$username][$crypto] += $quantity;
    } elseif ($action === 'sell') {
        // Vendre dimunue la qqt
        if (isset($wallets[$username][$crypto]) && $wallets[$username][$crypto] >= $quantity) {
            $wallets[$username][$crypto] -= $quantity;
        } else {
            $_SESSION['error'] = "Quantité insuffisante pour vendre.";
            header('Location: market.php');
            exit();
        }
    }

    //save dans le fichier json
    file_put_contents($walletFile, json_encode($wallets, JSON_PRETTY_PRINT));

    // Redirection avec succès
    $_SESSION['success'] = "Transaction effectuée avec succès.";
    header('Location: market.php');
    exit();
}
?>
