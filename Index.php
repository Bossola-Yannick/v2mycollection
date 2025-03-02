<?php
require './config.php';
include_once("./models/Famille.php");
include_once("./models/User.php");
session_start();
?>




<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/style_reset.css">
  <link rel="stylesheet" href="./assets/css/style_header-footer.css">
  <link rel="stylesheet" href="./assets/css/style_index.css">
  <title>My Collection</title>
</head>

<body>

  <header class="header">
    <img class="quiz-logo" src="./assets/img/mycollection.png" />
  </header>
  <main class="main-index">
    <h1 class="title">My Collection</h1>
    <h3 class="subtitle">Bienvenu sur votre plateforme de gestion de collection de la famille ou groupe</h3>
    <p class="connexion">Connectez vous pour accéder aux collection de votre famille ou groupe</p>
    <form action="" method="post">
      <button type="submit" name="connexion" class="button-connexion">Se Connecter</button>
    </form>
  </main>


  <?php include("./components/footer.php") ?>