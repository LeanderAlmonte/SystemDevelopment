<?php

namespace database;

class DBConnectionManager {
  
  //Properties
  private $username;
  private $password;
  private $server;
  private $dbname;

  private $dbConnection;

  //Constructor
  function __construct() {
    $this->username = "root";
    $this->pasword = "";
    $this->server = "localhost";
    $this->dbname = "eyesightcollectibles";

    try {
      $this->dbConnection = new \PDO("mysql:host=$this->server;dbname=$this->dbname", $this->username, $this->password);
    } catch (\PDOException $e) {
      print("Error: " . $e->getMessage());
    }

  }


  function getConnection() {
    return $this->dbConnection;
  }
}




?>