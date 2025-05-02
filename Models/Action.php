<?php

namespace models;

use database\DBConnectionManager;
use PDO;
use PDOException;

require_once(dirname(__DIR__) . '/core/db/DBConnectionManager.php');

class Action {
    private $actionID;
    private $userID;
    private $productID;
    private $clientID;
    private $timeStamp;
    private $quantity;
    private $actionType;
    private $description;
    private $oldValue;
    private $newValue;

    private $dbConnection;

    public function __construct() {
        $this->dbConnection = (new DBConnectionManager())->getConnection();
    }

    // Getters
    public function getActionID() {
        return $this->actionID;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getProductID() {
        return $this->productID;
    }

    public function getClientID() {
        return $this->clientID;
    }

    public function getTimeStamp() {
        return $this->timeStamp;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getActionType() {
        return $this->actionType;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getOldValue() {
        return $this->oldValue;
    }

    public function getNewValue() {
        return $this->newValue;
    }

    // Setters
    public function setActionID($actionID) {
        $this->actionID = $actionID;
        return $this;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
        return $this;
    }

    public function setProductID($productID) {
        $this->productID = $productID;
        return $this;
    }

    public function setClientID($clientID) {
        $this->clientID = $clientID;
        return $this;
    }

    public function setTimeStamp($timeStamp) {
        $this->timeStamp = $timeStamp;
        return $this;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    public function setActionType($actionType) {
        $this->actionType = $actionType;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setOldValue($oldValue) {
        $this->oldValue = $oldValue;
        return $this;
    }

    public function setNewValue($newValue) {
        $this->newValue = $newValue;
        return $this;
    }

    // CRUD Operations
    public function read($id = null) {
        if ($id) {
            $query = "SELECT * FROM actions WHERE actionID = :actionID";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->bindParam(':actionID', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM actions ORDER BY timeStamp DESC";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function create($data = null) {
        if ($data) {
            $this->setUserID($data['userID']);
            $this->setProductID($data['productID']);
            $this->setClientID($data['clientID']);
            $this->setTimeStamp($data['timeStamp']);
            $this->setQuantity($data['quantity']);
            $this->setActionType($data['actionType']);
            $this->setDescription($data['description']);
            $this->setOldValue($data['oldValue']);
            $this->setNewValue($data['newValue']);
        }

        $query = "INSERT INTO actions (userID, productID, clientID, timeStamp, quantity, actionType, description, oldValue, newValue) 
                 VALUES (:userID, :productID, :clientID, :timeStamp, :quantity, :actionType, :description, :oldValue, :newValue)";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':userID', $this->userID);
        $stmt->bindParam(':productID', $this->productID);
        $stmt->bindParam(':clientID', $this->clientID);
        $stmt->bindParam(':timeStamp', $this->timeStamp);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':actionType', $this->actionType);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':oldValue', $this->oldValue);
        $stmt->bindParam(':newValue', $this->newValue);
        
        try {
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['error' => 'Failed to create action'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function update($data = null) {
        if ($data) {
            $this->setActionID($data['actionID']);
            $this->setUserID($data['userID']);
            $this->setProductID($data['productID']);
            $this->setClientID($data['clientID']);
            $this->setTimeStamp($data['timeStamp']);
            $this->setQuantity($data['quantity']);
            $this->setActionType($data['actionType']);
            $this->setDescription($data['description']);
            $this->setOldValue($data['oldValue']);
            $this->setNewValue($data['newValue']);
        }

        $query = "UPDATE actions 
                 SET userID = :userID,
                     productID = :productID,
                     clientID = :clientID,
                     timeStamp = :timeStamp,
                     quantity = :quantity,
                     actionType = :actionType,
                     description = :description,
                     oldValue = :oldValue,
                     newValue = :newValue
                 WHERE actionID = :actionID";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':actionID', $this->actionID);
        $stmt->bindParam(':userID', $this->userID);
        $stmt->bindParam(':productID', $this->productID);
        $stmt->bindParam(':clientID', $this->clientID);
        $stmt->bindParam(':timeStamp', $this->timeStamp);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':actionType', $this->actionType);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':oldValue', $this->oldValue);
        $stmt->bindParam(':newValue', $this->newValue);
        
        try {
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['error' => 'Failed to update action'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function delete($id) {
        $query = "DELETE FROM actions WHERE actionID = :actionID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':actionID', $id);
        
        try {
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['error' => 'Failed to delete action'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function getByUserID($userID) {
        $query = "SELECT * FROM actions WHERE userID = :userID ORDER BY timeStamp DESC";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByProductID($productID) {
        $query = "SELECT * FROM actions WHERE productID = :productID ORDER BY timeStamp DESC";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':productID', $productID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByClientID($clientID) {
        $query = "SELECT * FROM actions WHERE clientID = :clientID ORDER BY timeStamp DESC";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':clientID', $clientID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
