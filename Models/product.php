<?php

namespace models;

use database\DBConnectionManager;
use PDO;
use PDOException;

require_once(dirname(__DIR__) . '/core/db/DBConnectionManager.php');

class Product {
    private $productID;
    private $productName;
    private $category;
    private $listedPrice;
    private $paidPrice;
    private $quantity;
    private $isArchived;
    private $isSold;

    private $dbConnection;

    public function __construct() {
        $this->dbConnection = (new DBConnectionManager())->getConnection();
    }

    // Getters
    public function getProductID() {
        return $this->productID;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getListedPrice() {
        return $this->listedPrice;
    }

    public function getPaidPrice() {
        return $this->paidPrice;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getIsArchived() {
        return $this->isArchived;
    }

    // Setters
    public function setProductID($productID) {
        $this->productID = $productID;
        return $this;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
        return $this;
    }

    public function setCategory($category) {
        $this->category = $category;
        return $this;
    }

    public function setListedPrice($listedPrice) {
        $this->listedPrice = $listedPrice;
        return $this;
    }

    public function setPaidPrice($paidPrice) {
        $this->paidPrice = $paidPrice;
        return $this;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    public function setIsArchived($isArchived) {
        $this->isArchived = $isArchived;
        return $this;
    }

    // CRUD Operations
    public function read($id = null) {
        if ($id) {
            $query = "SELECT * FROM products WHERE productID = :productID";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->bindParam(':productID', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM products WHERE isArchived = 0";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function create($data = null) {
        if ($data) {
            $this->setProductName($data['productName']);
            $this->setCategory($data['category']);
            $this->setListedPrice($data['listedPrice']);
            $this->setPaidPrice($data['paidPrice']);
            $this->setQuantity($data['quantity']);
            $this->setIsArchived(0);
        }

        $query = "INSERT INTO products (productName, category, listedPrice, paidPrice, quantity, isArchived) 
                 VALUES (:productName, :category, :listedPrice, :paidPrice, :quantity, :isArchived)";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':productName', $this->productName);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':listedPrice', $this->listedPrice);
        $stmt->bindParam(':paidPrice', $this->paidPrice);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':isArchived', $this->isArchived);
        
        try {
            if ($stmt->execute()) {
                $productID = $this->dbConnection->lastInsertId();
                
                // Create action record for the new product
                $action = new Action();
                $fullName = $_SESSION['userName']; // Get full name from session
                $actionData = [
                    'userID' => $_SESSION['userID'] ?? 1, // Get userID from session or default to 1
                    'productID' => $productID,
                    'clientID' => 0, // No client involved in adding product
                    'timeStamp' => date('Y-m-d H:i:s'),
                    'quantity' => $this->quantity,
                    'actionType' => 'ADD',
                    'description' => "{$fullName} added {$this->quantity} units of {$this->productName} to Inventory",
                    'oldValue' => '0', // No previous value
                    'newValue' => $this->quantity
                ];
                
                $action->create($actionData);
                
                return ['success' => true, 'productID' => $productID];
            } else {
                return ['error' => 'Failed to create product'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function update($data = null) {
        if ($data) {
            $this->setProductID($data['productID']);
            $this->setProductName($data['productName']);
            $this->setCategory($data['category']);
            $this->setListedPrice($data['listedPrice']);
            $this->setPaidPrice($data['paidPrice']);
            $this->setQuantity($data['quantity']);
        }

        // Get the old product data for comparison
        $oldProduct = $this->read($this->productID);
        if (!$oldProduct) {
            return ['error' => 'Product not found'];
        }

        $query = "UPDATE products 
                 SET productName = :productName, 
                     category = :category, 
                     listedPrice = :listedPrice, 
                     paidPrice = :paidPrice, 
                     quantity = :quantity 
                 WHERE productID = :productID";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':productID', $this->productID);
        $stmt->bindParam(':productName', $this->productName);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':listedPrice', $this->listedPrice);
        $stmt->bindParam(':paidPrice', $this->paidPrice);
        $stmt->bindParam(':quantity', $this->quantity);
        
        try {
            if ($stmt->execute()) {
                // Create action record for the update
                $action = new Action();
                $fullName = $_SESSION['userName']; // Get full name from session
                
                // Build description based on what changed
                $changes = [];
                if ($oldProduct['productName'] !== $this->productName) {
                    $changes[] = "name from '{$oldProduct['productName']}' to '{$this->productName}'";
                }
                if ($oldProduct['category'] !== $this->category) {
                    $changes[] = "category from '{$oldProduct['category']}' to '{$this->category}'";
                }
                if ($oldProduct['listedPrice'] !== $this->listedPrice) {
                    $changes[] = "listed price from '{$oldProduct['listedPrice']}' to '{$this->listedPrice}'";
                }
                if ($oldProduct['paidPrice'] !== $this->paidPrice) {
                    $changes[] = "paid price from '{$oldProduct['paidPrice']}' to '{$this->paidPrice}'";
                }
                if ($oldProduct['quantity'] !== $this->quantity) {
                    $changes[] = "quantity from '{$oldProduct['quantity']}' to '{$this->quantity}'";
                }
                
                $description = "{$fullName} updated product {$this->productName}: " . implode(", ", $changes);
                
                $actionData = [
                    'userID' => $_SESSION['userID'] ?? 1, // Get userID from session or default to 1
                    'productID' => $this->productID,
                    'clientID' => 0, // No client involved in update
                    'timeStamp' => date('Y-m-d H:i:s'),
                    'quantity' => $this->quantity,
                    'actionType' => 'UPDATE',
                    'description' => $description,
                    'oldValue' => json_encode($oldProduct),
                    'newValue' => json_encode([
                        'productName' => $this->productName,
                        'category' => $this->category,
                        'listedPrice' => $this->listedPrice,
                        'paidPrice' => $this->paidPrice,
                        'quantity' => $this->quantity
                    ])
                ];
                
                $action->create($actionData);
                
                return ['success' => true];
            } else {
                return ['error' => 'Failed to update product'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function delete($id) {
        // Get the product data before deleting
        $product = $this->read($id);
        if (!$product) {
            return ['error' => 'Product not found'];
        }

        $query = "DELETE FROM products WHERE productID = :productID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':productID', $id);
        
        try {
            if ($stmt->execute()) {
                // Create action record for the deletion
                $action = new Action();
                $fullName = $_SESSION['userName']; // Get full name from session
                
                $actionData = [
                    'userID' => $_SESSION['userID'] ?? 1, // Get userID from session or default to 1
                    'productID' => $id,
                    'clientID' => 0, // No client involved in deletion
                    'timeStamp' => date('Y-m-d H:i:s'),
                    'quantity' => $product['quantity'],
                    'actionType' => 'DELETE',
                    'description' => "{$fullName} deleted product {$product['productName']} from inventory",
                    'oldValue' => json_encode($product),
                    'newValue' => '0' // Product no longer exists
                ];
                
                $action->create($actionData);
                
                return ['success' => true];
            } else {
                return ['error' => 'Failed to delete product'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function archive($id) {
        // Get the product data before archiving
        $product = $this->read($id);
        if (!$product) {
            return ['error' => 'Product not found'];
        }

        $query = "UPDATE products SET isArchived = 1 WHERE productID = :productID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':productID', $id);
        
        try {
            if ($stmt->execute()) {
                // Create action record for archiving
                $action = new Action();
                $fullName = $_SESSION['userName']; // Get full name from session
                
                $actionData = [
                    'userID' => $_SESSION['userID'] ?? 1, // Get userID from session or default to 1
                    'productID' => $id,
                    'clientID' => 0, // No client involved in archiving
                    'timeStamp' => date('Y-m-d H:i:s'),
                    'quantity' => $product['quantity'],
                    'actionType' => 'ARCHIVE',
                    'description' => "{$fullName} archived product {$product['productName']}",
                    'oldValue' => json_encode($product),
                    'newValue' => json_encode(array_merge($product, ['isArchived' => 1]))
                ];
                
                $action->create($actionData);
                
                return ['success' => true];
            } else {
                return ['error' => 'Failed to archive product'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function unarchive($id) {
        // Get the product data before unarchiving
        $product = $this->read($id);
        if (!$product) {
            return ['error' => 'Product not found'];
        }

        $query = "UPDATE products SET isArchived = 0 WHERE productID = :productID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':productID', $id);
        
        try {
            if ($stmt->execute()) {
                // Create action record for unarchiving
                $action = new Action();
                $fullName = $_SESSION['userName']; // Get full name from session
                
                $actionData = [
                    'userID' => $_SESSION['userID'] ?? 1, // Get userID from session or default to 1
                    'productID' => $id,
                    'clientID' => 0, // No client involved in unarchiving
                    'timeStamp' => date('Y-m-d H:i:s'),
                    'quantity' => $product['quantity'],
                    'actionType' => 'UNARCHIVE',
                    'description' => "{$fullName} unarchived product {$product['productName']}",
                    'oldValue' => json_encode($product),
                    'newValue' => json_encode(array_merge($product, ['isArchived' => 0]))
                ];
                
                $action->create($actionData);
                
                return ['success' => true];
            } else {
                return ['error' => 'Failed to unarchive product'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function getArchivedProducts() {
        $query = "SELECT * FROM products WHERE isArchived = 1";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSoldProducts() {
        $query = "SELECT * FROM products WHERE isSold = 1";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>