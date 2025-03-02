<?php
if (!empty($_SESSION)) {
  // deconnexion
  if (isset($_POST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: ../index.php");
  }
};

if (isset($_POST['user-profil'])) {
  header("location: ./user.php");
  exit();
};
if (isset($_SESSION['userId'])) {
  $getUsers = new User();
  $userConnect = $getUsers->getUserById($_SESSION['userId']);
  $avatarProfil = $userConnect[0]['bin'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/header-footer.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>S-Quiz Game</title>
</head>

<body>

  <header class="header">
    <?php if (!isset($_SESSION['userId'])): ?>
      <!-- pas connecté  -->
      <div class="logo-box">
        <a href="../index.php">
          <img src="../assets/img/KameHouse.ico" class="logo-header" alt="accueil" />
        </a>
      </div>
      <img class="quiz-logo" src="../assets/img/mycollection.png" />
      <div class="logo-login">
        <a href="../pages/connexion.php">
          <img src="../assets/img/sheronBall.ico" alt="connexion">
        </a>
      </div>
    <?php else : ?>
      <!-- connecté USER -->
      <div class="logo-box">
        <a href="../index.php">
          <img src="../assets/img/KameHouse.ico" class="logo-header" alt="accueil" />
        </a>
      </div>
      <img class="quiz-logo" src="../assets/img/mycollection.png" />
      <form method="post" action="" class="box-login-disconnect">
        <?php if (isset($avatarProfil)): ?>
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
                <img src="../assets/img/boule_7.png" alt="avatar" />
              </div>
            </button>
          </div>
        <?php endif ?>
        <div class="logo-box">
          <button class="icon-account" type="submit" name="logout">
            <img src="../assets/img/deconnexion.png" alt="deconnexion" />
          </button>
        </div>
      </form>
    <?php endif; ?>

  </header>