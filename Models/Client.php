<?php

namespace models;

use database\DBConnectionManager;
use PDO;
use PDOException;

require_once(dirname(__DIR__) . '/core/db/DBConnectionManager.php');

class Client {
    private $clientID;
    private $clientName;
    private $email;
    private $phoneNumber;

    private $dbConnection;

    public function __construct() {
        $this->dbConnection = (new DBConnectionManager())->getConnection();
    }

    // Getters
    public function getClientID() {
        return $this->clientID;
    }

    public function getClientName() {
        return $this->clientName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    // Setters
    public function setClientID($clientID) {
        $this->clientID = $clientID;
        return $this;
    }

    public function setClientName($clientName) {
        $this->clientName = $clientName;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    // CRUD Operations
    public function read($id = null) {
        if ($id) {
            $query = "SELECT * FROM clients WHERE clientID = :clientID";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->bindParam(':clientID', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM clients ORDER BY clientName ASC";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function create($data = null) {
        if ($data) {
            $this->setClientName($data['clientName']);
            $this->setEmail($data['email']);
            $this->setPhoneNumber($data['phone']);
        }

        $query = "INSERT INTO clients (clientName, email, phoneNumber) 
                 VALUES (:clientName, :email, :phoneNumber)";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':clientName', $this->clientName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phoneNumber', $this->phoneNumber);
        
        try {
            if ($stmt->execute()) {
                return ['success' => true, 'clientID' => $this->dbConnection->lastInsertId()];
            } else {
                return ['error' => 'Failed to create client'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function update($data = null) {
        if ($data) {
            $this->setClientID($data['clientID']);
            $this->setClientName($data['clientName']);
            $this->setEmail($data['email']);
            $this->setPhoneNumber($data['phone']);
        }

        $query = "UPDATE clients 
                 SET clientName = :clientName, 
                     email = :email, 
                     phoneNumber = :phoneNumber 
                 WHERE clientID = :clientID";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':clientID', $this->clientID);
        $stmt->bindParam(':clientName', $this->clientName);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phoneNumber', $this->phoneNumber);
        
        try {
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['error' => 'Failed to update client'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function delete($id) {
        $query = "DELETE FROM clients WHERE clientID = :clientID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':clientID', $id);
        
        try {
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['error' => 'Failed to delete client'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    // Search clients
    public function search($searchTerm) {
        $searchTerm = "%$searchTerm%";
        $query = "SELECT * FROM clients 
                 WHERE clientName LIKE :searchTerm 
                 OR email LIKE :searchTerm 
                 OR phoneNumber LIKE :searchTerm 
                 ORDER BY clientName ASC";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get client by email
    public function getClientByEmail($email) {
        $query = "SELECT * FROM clients WHERE email = :email";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get client by phone number
    public function getClientByPhone($phoneNumber) {
        $query = "SELECT * FROM clients WHERE phoneNumber = :phoneNumber";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
