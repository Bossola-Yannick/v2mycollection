<?php
include_once(__DIR__ . "/Bdd.php");
class Avatar extends Bdd
{

  public function __construct()
  {
    parent::__construct($this->bdd);
  }

  // créer image
  public function createAvatar($nom, $taille, $type, $tmp_name, $id_user)
  {
    // Déplacer le fichier téléchargé vers un répertoire permanent
    $target_dir = "../assets/img/avatar/";
    $target_file = $target_dir . basename($nom);
    if (move_uploaded_file($tmp_name, $target_file)) {
      $sql = "INSERT INTO avatar (nom, taille, type, bin, id_user) VALUES (:nom, :taille, :type, :bin, :id_user)";
      $create = $this->bdd->prepare($sql);
      $create->execute([
        ':nom' => $nom,
        ':taille' => intval($taille),
        ':type' => $type,
        ':bin' => $target_file,
        ':id_user' => intval($id_user)
      ]);
    }
  }

  // modifier image
  public function updateAvatar($id_image, $nom, $taille, $type, $tmp_name, $id_user)
  {
    $target_dir = "../assets/img/avatar/";
    $target_file = $target_dir . basename($nom);
    if (move_uploaded_file($tmp_name, $target_file)) {
      $sql = "UPDATE avatar SET nom = :nom, taille =:taille, type =:type, bin =:bin, id_user=:id_user WHERE id = :id";
      $create = $this->bdd->prepare($sql);
      $create->execute([
        ':id' => $id_image,
        ':nom' => $nom,
        ':taille' => intval($taille),
        ':type' => intval($type),
        ':bin' => $target_file,
        ':id_user' => intval($id_user)
      ]);
    }
  }
  public function getAvatarByUserId($userId)
  {
    $sql = "SELECT avatar.bin FROM avatar WHERE id_user = $userId";
    $getAvatar = $this->bdd->prepare($sql);
    $getAvatar->execute();
    return $getAvatar->fetchAll(PDO::FETCH_ASSOC);
  }
}
