<?php
require_once(__DIR__ . "/Bdd.php");


class Item extends Bdd
{

  public function __construct()
  {
    parent::__construct($this->bdd);
  }


  // récupération de toute la collection par utilisateur
  public function getAllItemByUser($userId)
  {
    $sql = "SELECT item.*, image.id as imageId, image.nom as ImageNom, image.taille, image.type, image.bin, image.id_item 
    FROM item
    LEFT JOIN image On image.id_item = item.id
    WHERE item.id_user = $userId";
    $getItem = $this->bdd->prepare($sql);
    $getItem->execute();
    return $getItem->fetchAll(PDO::FETCH_ASSOC);
  }


  // creation d'élément de la collection
  public function createItem($nom, $description, $userId)
  {

    $sql = "INSERT INTO item (nom, description, id_user) VALUES (:nom, :description, :id_user)";
    $create = $this->bdd->prepare($sql);
    $create->execute([
      ':nom' => $nom,
      ':description' => $description,
      ':id_user' => $userId
    ]);
  }

  // suppression d'élément de la collection
  public function delete($id)
  {

    $sql = "DELETE FROM item WHERE id = $id";
    $delete = $this->bdd->prepare($sql);
    $delete->execute();
  }

  // récupérer le dernier ITEM créer
  public function getLastItem()
  {

    $sql = "SELECT id
  FROM item
  ORDER BY id DESC
  LIMIT 1";
    $selectLast = $this->bdd->prepare($sql);
    $selectLast->execute();
    return $selectLast->fetchAll(PDO::FETCH_ASSOC);
  }
}
