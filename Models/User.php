<?php

namespace models;

use database\DBConnectionManager;
use PDO;

require_once(dirname(__DIR__) . '/core/db/DBConnectionManager.php');

class User{

    private $userId;
    private $firstName;
    private $lastName;
    private $password;
    private $email;
    private $userType;
    private $theme;

    private $dbConnection;

    public function __construct() {
        $this->dbConnection = (new DBConnectionManager())->getConnection();
    }

    // Getters
    public function getUserId() {
        return $this->userId;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUserType() {
        return $this->userType;
    }

    public function getTheme() {
        return $this->theme;
    }

    // Setters
    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setUserType($userType) {
        $this->userType = $userType;
        return $this;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
        return $this;
    }

    // CRUD Operations
    public function read($id = null) {
        if ($id) {
            $query = "SELECT * FROM users WHERE userId = :userId";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->bindParam(':userId', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM users";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function create() {
        $query = "INSERT INTO users (firstName, lastName, password, email, userType, theme) 
                 VALUES (:firstName, :lastName, :password, :email, :userType, :theme)";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':userType', $this->userType);
        $stmt->bindParam(':theme', $this->theme);
        
        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE users 
                 SET firstName = :firstName, 
                     lastName = :lastName, 
                     password = :password, 
                     email = :email, 
                     userType = :userType, 
                     theme = :theme 
                 WHERE userId = :userId";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':userType', $this->userType);
        $stmt->bindParam(':theme', $this->theme);
        
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM users WHERE userId = :userId";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':userId', $this->userId);
        return $stmt->execute();
    }
    
    
    
    
}