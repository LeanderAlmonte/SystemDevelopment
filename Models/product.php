<?php

namespace models;

use database\DBConnectionManager;
use PDO;
use PDOException;

require_once(dirname(__DIR__) . '/core/db/DBConnectionManager.php');
require_once(dirname(__DIR__) . '/models/Action.php');

// Set timezone to Montreal
date_default_timezone_set('America/Montreal');

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
                $action = new \models\Action();
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
                // Log session state
                error_log("Session state before action creation:");
                error_log("userID: " . ($_SESSION['userID'] ?? 'not set'));
                error_log("userName: " . ($_SESSION['userName'] ?? 'not set'));
                error_log("Full session data: " . print_r($_SESSION, true));

                // Create action record for the update
                $action = new \models\Action();
                $fullName = $_SESSION['userName'] ?? 'Unknown User';
                
                // Track which fields were modified
                $modifiedFields = [];
                
                // Product Name comparison
                $oldName = $this->normalizeString($oldProduct['productName']);
                $newName = $this->normalizeString($this->productName);
                error_log("Product Name - Old: '{$oldName}', New: '{$newName}'");
                if ($oldName != $newName) {
                    $modifiedFields[] = [
                        'field' => 'productName',
                        'old' => $oldProduct['productName'],
                        'new' => $this->productName,
                        'description' => "name from '{$oldProduct['productName']}' to '{$this->productName}'"
                    ];
                }
                
                // Category comparison
                $oldCategory = $this->normalizeString($oldProduct['category']);
                $newCategory = $this->normalizeString($this->category);
                error_log("Category - Old: '{$oldCategory}', New: '{$newCategory}'");
                if ($oldCategory != $newCategory) {
                    // Get user-friendly category names
                    require_once(dirname(__DIR__) . '/Controllers/ProductController.php');
                    $productController = new \Controllers\ProductController();
                    $categories = $productController->getCategories();
                    $oldLabel = $categories[$oldProduct['category']] ?? $oldProduct['category'];
                    $newLabel = $categories[$this->category] ?? $this->category;
                    $modifiedFields[] = [
                        'field' => 'category',
                        'old' => $oldProduct['category'],
                        'new' => $this->category,
                        'description' => "category from '{$oldLabel}' to '{$newLabel}'"
                    ];
                }
                
                // Listed Price comparison
                $oldListedPrice = $this->normalizeNumber($oldProduct['listedPrice']);
                $newListedPrice = $this->normalizeNumber($this->listedPrice);
                error_log("Listed Price - Old: '{$oldListedPrice}', New: '{$newListedPrice}'");
                if ($oldListedPrice != $newListedPrice) {
                    $modifiedFields[] = [
                        'field' => 'listedPrice',
                        'old' => $oldProduct['listedPrice'],
                        'new' => $this->listedPrice,
                        'description' => "listed price from '{$oldProduct['listedPrice']}' to '{$this->listedPrice}'"
                    ];
                }
                
                // Paid Price comparison
                $oldPaidPrice = $this->normalizeNumber($oldProduct['paidPrice']);
                $newPaidPrice = $this->normalizeNumber($this->paidPrice);
                error_log("Paid Price - Old: '{$oldPaidPrice}', New: '{$newPaidPrice}'");
                if ($oldPaidPrice != $newPaidPrice) {
                    $modifiedFields[] = [
                        'field' => 'paidPrice',
                        'old' => $oldProduct['paidPrice'],
                        'new' => $this->paidPrice,
                        'description' => "paid price from '{$oldProduct['paidPrice']}' to '{$this->paidPrice}'"
                    ];
                }
                
                // Quantity comparison
                $oldQuantity = $this->normalizeNumber($oldProduct['quantity']);
                $newQuantity = $this->normalizeNumber($this->quantity);
                error_log("Quantity - Old: '{$oldQuantity}', New: '{$newQuantity}'");
                if ($oldQuantity != $newQuantity) {
                    $modifiedFields[] = [
                        'field' => 'quantity',
                        'old' => $oldProduct['quantity'],
                        'new' => $this->quantity,
                        'description' => "quantity from {$oldProduct['quantity']} to {$this->quantity}"
                    ];
                }
                
                error_log("Modified fields: " . print_r($modifiedFields, true));
                
                // Create separate action records for each modified field
                foreach ($modifiedFields as $field) {
                $actionData = [
                        'userID' => $_SESSION['userID'] ?? 1,
                    'productID' => $this->productID,
                        'clientID' => 0,
                    'timeStamp' => date('Y-m-d H:i:s'),
                    'quantity' => $this->quantity,
                    'actionType' => 'UPDATE',
                        'description' => "{$fullName} updated product {$this->productName}'s {$field['description']}",
                        'oldValue' => json_encode([$field['field'] => $field['old']]),
                        'newValue' => json_encode([$field['field'] => $field['new']])
                    ];
                    
                    error_log("Creating action record for {$field['field']} update:");
                    error_log("Action data: " . print_r($actionData, true));
                    
                    try {
                        $result = $action->create($actionData);
                        error_log("Action create result for {$field['field']}: " . print_r($result, true));
                        if (isset($result['error'])) {
                            error_log("Failed to create action record for {$field['field']}: " . $result['error']);
                        } else {
                            error_log("Successfully created action record for {$field['field']}");
                        }
                    } catch (\Exception $e) {
                        error_log("Exception while creating action record for {$field['field']}: " . $e->getMessage());
                        error_log("Exception trace: " . $e->getTraceAsString());
                    }
                }
                
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
                $action = new \models\Action();
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
                $action = new \models\Action();
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
                $action = new \models\Action();
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

    // Get archived products (archived products page)   
    public function getArchivedProducts() {
        $query = "SELECT * FROM products WHERE isArchived = 1";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get sold products (sold products page)
    public function getSoldProducts() {
        $query = "SELECT * FROM products WHERE isSold = 1";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get most stocked products (home page)
    public function getMostStocked($limit = 5) {
        $query = "SELECT productID, productName, quantity 
                 FROM products 
                 WHERE isArchived = 0 
                 ORDER BY quantity DESC 
                 LIMIT :limit";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update quantity for sale (Process Order Function)
    public function updateQuantityForSale($productID, $newQuantity) {
        $query = "UPDATE products 
                 SET quantity = :quantity 
                 WHERE productID = :productID";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':productID', $productID);
        $stmt->bindParam(':quantity', $newQuantity);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Normalize strings for comparison
    private function normalizeString($string) {
        return strtolower(trim($string));
    }

    // Normalize numbers for comparison
    private function normalizeNumber($number) {
        return floatval($number);
    }
}

?>