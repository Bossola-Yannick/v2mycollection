<?php

class Bdd
{
  protected $bdd;
  public function __construct()
  {
    $host = $_ENV['BDD_URL'];
    $username = $_ENV['BDD_USERNAME'];
    $password = $_ENV['BDD_PASSWORD'];
    $dbName = $_ENV['BDD_NAME'];
    try {
      $this->bdd  = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
      $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Erreur : " . $e->getMessage());
    }
  }
}
