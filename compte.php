<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Bienvenue</title>
  <link rel="icon" href="https://cdn.icon-icons.com/icons2/1385/PNG/512/btc-crypto-cryptocurrency-cryptocurrencies-cash-money-bank-payment_95386.png">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/assets.css">
</head>

<body>
  <?php include "./assets/header.html"; ?>
  <main>
    <?php
    if (isset($_SESSION["user"])) 
    {
      $emailConnecte = $_SESSION["user"]["email"];
      $fichierJSON = './data/user.json';
      $contenu = file_get_contents($fichierJSON);
      $utilisateurs = json_decode($contenu, true);
      $utilisateurTrouve = null;

      foreach ($utilisateurs as $utilisateur) {
        if ($utilisateur["email"] === $emailConnecte) {
          $utilisateurTrouve = $utilisateur;
          break;
        }
      }

      if ($utilisateurTrouve) { ?>
        <h1>Bienvenue, <?= htmlspecialchars($utilisateurTrouve["prenom"]) . " " . htmlspecialchars($utilisateurTrouve["nom"]) ?></h1>
        <ul class="user-info">
          <li>Email : <?= htmlspecialchars($utilisateurTrouve["email"]) ?></li>
          <li>Nom : <?= htmlspecialchars($utilisateurTrouve["nom"]) ?></li>
          <li>Prénom : <?= htmlspecialchars($utilisateurTrouve["prenom"]) ?></li>
          <li>Date de création du compte : <?= htmlspecialchars($utilisateurTrouve["date_creation"]) ?></li>
        </ul>
        <a href="logout.php" class="start">Se déconnecter</a>
      <?php  
      }
    } 
    else { ?>
    <h1>Hmmm, on dirait que vous n'êtes pas connecté...</h1>
      <a class="start" href="./connection.php">Se connecter</a>
    <?php } ?>
  </main>
  <?php include "./assets/footer.html"; ?>
</body>

</html>