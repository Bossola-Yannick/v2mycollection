<?php
include_once(__DIR__ . "/Bdd.php");


class User extends Bdd
{
  public string $login;
  public string $password;
  public string $role;

  public function __construct()
  {
    parent::__construct($this->bdd);
  }

  // Methode inscription

  public function userSignUp($userLogin, $userPass)
  {
    $checkStmt = "SELECT id 
        FROM user
        WHERE login = :userLogin";
    $checkStmt = $this->bdd->prepare($checkStmt);
    $checkStmt->execute([
      ':userLogin' => $userLogin
    ]);

    if ($checkStmt->fetch()) {
      $_SESSION['message']  = "Ce pseudo est déjà utilisé !";
    } else {

      $signUpStmt = "INSERT INTO user (login, password, role) VALUES (:login, :password, :role)";
      $signUpStmt = $this->bdd->prepare($signUpStmt);
      $signUpStmt->execute([
        ':login' => $userLogin,
        ':password' => $userPass,
        ':role' => 'user'
      ]);

      $signUpStmt = $signUpStmt->fetch(PDO::FETCH_ASSOC);

      $_SESSION['message']  = "Inscription réussie !";

      header("location:connexion.php");
    }
  }

  // Methode connexion
  public function userConnexion($userLogin, $userPass): void
  {
    $loginStmt = "SELECT user.*, avatar.id as avatarId, avatar.nom,avatar.taille,avatar.type,avatar.bin ,avatar.id_user 
                  FROM user 
                  LEFT JOIN avatar ON avatar.id_user = user.id
                  WHERE login = :userLogin";
    $loginStmt = $this->bdd->prepare($loginStmt);
    $loginStmt->execute([
      ':userLogin' => $userLogin
    ]);
    $userLogin = $loginStmt->fetch(PDO::FETCH_ASSOC);
    if ($userLogin && (password_verify($userPass, $userLogin['password'])) || ($userLogin && $userPass == $userLogin['password'])) {
      // session_start();
      $_SESSION['userId'] = $userLogin['id'];
      $_SESSION['userLogin'] = $userLogin['login'];
      $_SESSION['userRole'] = $userLogin['role'];
      $_SESSION['familyId'] = $userLogin['id_famille'];
      $_SESSION['avatarId'] = $userLogin['avatarId'];
      $_SESSION['avatarProfil'] = str_replace('../', './', $userLogin['bin']);
      header("location: ../index.php");
      exit();
    } else {
      $_SESSION['message']  = "Pseudo ou mot de passe incorrect!";
    }
  }

  // Méthode pour update user login
  public function updateUserLogin($userLogin, $newLogin): void
  {
    $checkStmt = "SELECT user.login 
        FROM user
        WHERE login = :newLogin";
    $checkStmt = $this->bdd->prepare($checkStmt);
    $checkStmt->execute([
      ':newLogin' => $newLogin
    ]);

    if ($checkStmt->fetch()) {
      $_SESSION['message']  = "Ce pseudo est déjà utilisé !";
    } else {

      $newLoginStmt = "UPDATE user SET login = :newLogin
            WHERE login = :userLogin";
      $newLoginStmt = $this->bdd->prepare($newLoginStmt);
      $newLoginStmt->execute([
        ':userLogin' => $userLogin,
        ':newLogin' => $newLogin
      ]);

      $_SESSION['message'] = "Pseudo modifié";
      $_SESSION['userLogin'] = $newLogin;
    }
  }

  // Méthode pour vérifier et update le mot de passe
  public function updateUserPassword($userId, $currentPass, $newPass)
  {
    // récup mdp actuel
    $passStmt = "SELECT user.password
        FROM user
        WHERE user.id = :userId";
    $passStmt = $this->bdd->prepare($passStmt);
    $passStmt->execute([
      ':userId' => $userId
    ]);
    $userPass = $passStmt->fetch(PDO::FETCH_ASSOC);

    // vérifie s'il est correct
    if (password_verify($currentPass, $userPass['password']) ||  $currentPass == $userPass['password']) {
      $newHashPass = password_hash($newPass, PASSWORD_BCRYPT);

      // met a jour le mot de passe
      $updatePassStmt = "UPDATE user 
            SET password = :newPass 
            WHERE user.id = :userId";
      $updatePassStmt = $this->bdd->prepare($updatePassStmt);
      $updatePassStmt->execute([
        ':newPass' => $newHashPass,
        ':userId' => $userId
      ]);

      $_SESSION['message'] = "Succès - Mot de passe changé !";
    } else {
      $_SESSION['message'] = "Erreur - Mot de passe incorrect !";
    }
  }

  // Méthode pour récupérer tout les USER
  public function getAllUser()
  {
    $sql = "SELECT user.*, avatar.id as avatarId, avatar.nom,avatar.taille,avatar.type,avatar.bin ,avatar.id_user 
                  FROM user 
                  LEFT JOIN avatar ON avatar.id_user = user.id ORDER BY user.id ASC";
    $getAllUser = $this->bdd->prepare($sql);
    $getAllUser->execute();
    return $getAllUser->fetchAll(PDO::FETCH_ASSOC);
  }

  // Méthode pour récupérer un USER par son Id
  public function getUserById($userId)
  {
    $sql = "SELECT user.*, avatar.id as avatarId, avatar.nom,avatar.taille,avatar.type,avatar.bin ,avatar.id_user 
                  FROM user 
                  LEFT JOIN avatar ON avatar.id_user = user.id 
                  WHERE user.id = $userId
                  ORDER BY user.id ASC";
    $getAllUser = $this->bdd->prepare($sql);
    $getAllUser->execute();
    return $getAllUser->fetchAll(PDO::FETCH_ASSOC);
  }
}
