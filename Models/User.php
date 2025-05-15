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
    private $language;

    private $dbConnection;

    public function __construct() {
        $this->dbConnection = (new DBConnectionManager())->getConnection();
    }

    public function __destruct() {
        $this->dbConnection = null;
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

    public function getLanguage() {
        return $this->language;
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

    public function setLanguage($language) {
        $this->language = $language;
        return $this;
    }

    // CRUD Operations
    public function read($id = null) {
        try {
        if ($id !== null) {
            $query = "SELECT * FROM users WHERE userID = :userID";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->bindParam(':userID', $id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $this->setLanguage($user['language'] ?? 'en');
            }
            return $user;
        } else {
            $query = "SELECT * FROM users";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            error_log("Database error in read: " . $e->getMessage());
            return false;
        }
    }

    public function create($data = null) {
        try {
        if ($data) {
            // Validate email format
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strpos($data['email'], '@') === false) {
                return ['error' => 'Please enter a valid email address'];
            }

            $this->setFirstName($data['firstName']);
            $this->setLastName($data['lastName']);
            $this->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
            $this->setEmail($data['email']);
            $this->setUserType($data['userType']);
            $this->setTheme($data['theme']);
            $this->setTwoFactorEnabled(false);
            $this->setLanguage($data['language'] ?? 'en');
        }

        $query = "INSERT INTO users (firstName, lastName, password, email, userType, theme, twoFactorEnabled, language) 
                 VALUES (:firstName, :lastName, :password, :email, :userType, :theme, :twoFactorEnabled, :language)";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':userType', $this->userType);
        $stmt->bindParam(':theme', $this->theme);
        $stmt->bindParam(':twoFactorEnabled', $this->twoFactorEnabled);
        $stmt->bindParam(':language', $this->language);
        
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['error' => 'Failed to create user'];
            }
        } catch (PDOException $e) {
            error_log("Database error in create: " . $e->getMessage());
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
                theme = :theme,
                language = :language";
            
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
                ':theme' => $this->theme,
                ':language' => $this->language
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
                ':enabled' => $enabled ? 1 : 0,
                ':userId' => $userId
            ];
            
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Find user by email for login
    public function findByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Delete user
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

    // Get user by ID
    public function getUserById($userId) {
        $query = "SELECT * FROM users WHERE userID = :userID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Save reset token for password reset (unimplemented)
    public function saveResetToken($userID, $token, $expiry) {
        $sql = "UPDATE users SET token = ?, tokenExpiry = ? WHERE userID = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute([$token, $expiry, $userID]);
    }

    // Update user password
    public function updatePassword($userID, $hashedPassword) {
        $sql = "UPDATE users SET password = ? WHERE userID = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute([$hashedPassword, $userID]);
    }

    // Clear reset token (unimplemented)
    public function clearResetToken($userID) {
        $sql = "UPDATE users SET token = NULL, tokenExpiry = NULL WHERE userID = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute([$userID]);
    }

    // Check if 2FA is enabled for a user
    public function is2FAEnabled($userID) {
        $query = "SELECT twoFactorEnabled FROM users WHERE userID = :userID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['twoFactorEnabled'] == 1;
    }
}