<?php

namespace Models;

use Database\DBConnectionManager;
use PDO;
use PDOException;

require_once(dirname(__DIR__) . '/Core/Db/DBConnectionManager.php');

class User{

    private int $userID;
    private $firstName;
    private $lastName;
    private $password;
    private $email;
    private $userType;
    private $theme;
    private $secretKey;
    private $twoFactorEnabled;

    private $dbConnection;

    public function __construct() {
        $this->dbConnection = (new DBConnectionManager())->getConnection();
    }

    // Getters
    public function getUserID() {
        return $this->userID;
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

    public function getSecretKey() {
        return $this->secretKey;
    }

    public function getTwoFactorEnabled() {
        return $this->twoFactorEnabled;
    }

    // Setters
    public function setUserID($userID) {
        $this->userID = $userID;
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

    public function setSecretKey($secret) {
        $this->secretKey = $secret;
        return $this;
    }

    public function setTwoFactorEnabled($enabled) {
        $this->twoFactorEnabled = $enabled;
        return $this;
    }

    // CRUD Operations
    public function read($id = null) {
        if ($id !== null) {
            $query = "SELECT * FROM users WHERE userID = :userID";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->bindParam(':userID', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM users";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function create($data = null) {
        if ($data) {
            $this->setFirstName($data['firstName']);
            $this->setLastName($data['lastName']);
            $this->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
            $this->setEmail($data['email']);
            $this->setUserType($data['userType']);
            $this->setTheme($data['theme']);
            $this->setTwoFactorEnabled(false);
        }

        $query = "INSERT INTO users (firstName, lastName, password, email, userType, theme, twoFactorEnabled) 
                 VALUES (:firstName, :lastName, :password, :email, :userType, :theme, :twoFactorEnabled)";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':userType', $this->userType);
        $stmt->bindParam(':theme', $this->theme);
        $stmt->bindParam(':twoFactorEnabled', $this->twoFactorEnabled);
        
        try {
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['error' => 'Failed to create user'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function update() {
        try {
            $query = "UPDATE users SET 
                firstName = :firstName,
                lastName = :lastName,
                email = :email,
                userType = :userType,
                theme = :theme";
            
            // Only include password in update if it's set
            if ($this->password !== null) {
                $query .= ", password = :password";
            }
            
            $query .= " WHERE userID = :userID";
            
            $stmt = $this->dbConnection->prepare($query);
            
            $params = [
                ':userID' => $this->userID,
                ':firstName' => $this->firstName,
                ':lastName' => $this->lastName,
                ':email' => $this->email,
                ':userType' => $this->userType,
                ':theme' => $this->theme
            ];
            
            if ($this->password !== null) {
                $params[':password'] = $this->password;
            }
            
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update2FASettings($userId, $secret, $enabled) {
        try {
            $query = "UPDATE users SET 
                secretKey = :secret,
                twoFactorEnabled = :enabled
                WHERE userID = :userId";
            
            $stmt = $this->dbConnection->prepare($query);
            $params = [
                ':secret' => $secret,
                ':enabled' => $enabled ? 1 : 0, // Convert boolean to integer
                ':userId' => $userId
            ];
            
            // Execute the query
            $result = $stmt->execute($params);
            
            // Store debug info in session
            $_SESSION['debug_db'] = [
                'query' => $query,
                'params' => $params,
                'result' => $result,
                'rowCount' => $stmt->rowCount()
            ];
            
            return $result;
        } catch (PDOException $e) {
            $_SESSION['debug_db'] = [
                'error' => $e->getMessage(),
                'query' => $query,
                'params' => $params
            ];
            return false;
        }
    }

    public function findByEmail($email) {
        error_log("Finding user by email: " . $email);
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Query result: " . ($result ? "User found" : "No user found"));
        if ($result) {
            error_log("User data: " . print_r($result, true));
        }
        return $result;
    }

    public function delete() {
        $query = "DELETE FROM users WHERE userID = :userID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':userID', $this->userID);
        
        try {
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['error' => 'Failed to delete user'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function getUserById($userId) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
}