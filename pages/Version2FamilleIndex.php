<?php
require './config.php';
include_once("./models/Famille.php");
include_once("./models/User.php");
session_start();
var_dump($_SESSION);
$getFamily = new Famille();
$users = $getFamily->getAllfamillyMembers($_SESSION['familyId']);
var_dump($users);
$getUsers = new User();
if (isset($_POST['user-profil'])) {
  header("location: ./pages/user.php");
  exit();
}
if (isset($_POST['user-collection'])) {
  $_SESSION['collectionId'] = $_POST['collectionId'];
  $_SESSION['collectionLogin'] = $_POST['collectionLogin'];
  header('location: ./pages/user-collection.php');
  exit();
}

if (isset($_SESSION['userId'])) {
  $userConnect = $getUsers->getUserById($_SESSION['userId']);
  if (empty($userConnect[0]['bin'])) {
    $avatarProfil = "./assets/img/boule_7.png";
  } else {
    $avatarProfil = str_replace('../', './', $userConnect[0]['bin']);
  }
}

// deconnexion
if (isset($_POST['logout'])) {
  $_SESSION = array();
  session_destroy();
  header("Location: ./index.php");
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/header-footer.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <title>My Collection</title>
</head>

<body>

  <header class="header">
    <?php if (!isset($_SESSION['userId'])): ?>
      <!-- pas connecté  -->
      <div class="logo-box">
        <a href="./index.php">
          <img src="./assets/img/KameHouse.ico" class="logo-header" alt="accueil" />
        </a>
      </div>
      <img class="quiz-logo" src="./assets/img/mycollection.png" />
      <div class="logo-login">
        <a href="./pages/connexion.php">
          <img src="./assets/img/sheronBall.ico" alt="connexion">
        </a>
      </div>
    <?php else : ?>
      <!-- connecté USER -->
      <div class="logo-box">
        <a href="./index.php">
          <img src="./assets/img/KameHouse.ico" class="logo-header" alt="accueil" />
        </a>
      </div>
      <img class="quiz-logo" src="./assets/img/mycollection.png" />
      <form method="post" action="" class="box-login-disconnect">
        <?php if (isset($avatarProfil)) : ?>
          <div class="logo-box">
            <button class="icon-account" type="submit" name="user-profil">
              <div class="box-account">
                <img src="<?= $avatarProfil ?>" alt="avatar" />
              </div>
            </button>
          </div>
        <?php else : ?>
          <div class="logo-box">
            <button class="icon-account" type="submit" name="user-profil">
              <div class="box-account">
                <img src="./assets/img/boule_7.png" alt="avatar" />
              </div>
            </button>
          </div>
        <?php endif ?>
        <div class="logo-box">
          <button class="icon-account" type="submit" name="logout">
            <img src="./assets/img/deconnexion.png" alt="deconnexion" />
          </button>
        </div>
      </form>
    <?php endif; ?>

  </header>

  <main class="home-page">

    <h1 class="title">Family Collection</h1>

    <h3 class="subtitle">Sélectionnez quelle collection voir</h3>

    <section class="profil">
      <?php foreach ($users as $user) : ?>
        <?php if (!empty($user['bin'])) {
          $avatar = str_replace('../', './', $user['bin']);
        } else $avatar = "./assets/img/boule_7.png" ?>
        <article class="profil-item">
          <form method="post">
            <input type="hidden" name="collectionId" value=<?= $user['id'] ?>>
            <input type="hidden" name="collectionLogin" value=<?= $user['login'] ?>>
            <button type="submit" class="avatar-button" name="user-collection">

              <figure class="profil-picture"><img src="<?= $avatar ?>" alt="profil de yannick"></figure>
            </button>
          </form>
          <h3 class="profil-name"><?= $user['login'] ?></h3>
        </article>

      <?php endforeach ?>

    </section>


  </main>