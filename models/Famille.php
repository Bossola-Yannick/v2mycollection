<?php
include_once(__DIR__ . "/Bdd.php");

class Famille extends Bdd
{

  public function __construct()
  {
    parent::__construct($this->bdd);
  }


  public function getAllfamillyMembers($idFamily)
  {
    $sql = "SELECT famille.id, famille.nom, user.id as userId,user.login,user.role, user.id_famille, avatar.id as avatarId,avatar.nom as avatarNom, avatar.bin,avatar.id_user
FROM famille
LEFT JOIN user ON user.id_famille = famille.id
LEFT JOIN avatar On avatar.id_user = user.id
WHERE famille.id = $idFamily";
    $getAllMembers = $this->bdd->prepare($sql);
    $getAllMembers->execute();
    return $getAllMembers->fetchAll(PDO::FETCH_ASSOC);
  }
}
