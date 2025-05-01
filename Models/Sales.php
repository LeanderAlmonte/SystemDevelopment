<?php

namespace models;

use database\DBConnectionManager;
use PDO;
use PDOException;

require_once(dirname(__DIR__) . '/core/db/DBConnectionManager.php');

class Sales {
    private $saleID;
    private $productID;
    private $quantitySold;
    private $salePrice;
    private $saleDate;

    private $dbConnection;

    public function __construct() {
        $this->dbConnection = (new DBConnectionManager())->getConnection();
    }

    // Getters
    public function getSaleID() {
        return $this->saleID;
    }

    public function getProductID() {
        return $this->productID;
    }

    public function getQuantitySold() {
        return $this->quantitySold;
    }

    public function getSalePrice() {
        return $this->salePrice;
    }

    public function getSaleDate() {
        return $this->saleDate;
    }

    // Setters
    public function setSaleID($saleID) {
        $this->saleID = $saleID;
        return $this;
    }

    public function setProductID($productID) {
        $this->productID = $productID;
        return $this;
    }

    public function setQuantitySold($quantitySold) {
        $this->quantitySold = $quantitySold;
        return $this;
    }

    public function setSalePrice($salePrice) {
        $this->salePrice = $salePrice;
        return $this;
    }

    public function setSaleDate($saleDate) {
        $this->saleDate = $saleDate;
        return $this;
    }

    // CRUD Operations
    public function read($id = null) {
        if ($id) {
            $query = "SELECT s.*, p.productName 
                     FROM sales s 
                     JOIN products p ON s.productID = p.productID 
                     WHERE s.saleID = :saleID";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->bindParam(':saleID', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT s.*, p.productName 
                     FROM sales s 
                     JOIN products p ON s.productID = p.productID 
                     ORDER BY s.saleDate DESC";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function create($data = null) {
        if ($data) {
            $this->setProductID($data['productID']);
            $this->setQuantitySold($data['quantitySold']);
            $this->setSalePrice($data['salePrice']);
            $this->setSaleDate(date('Y-m-d H:i:s')); // Current date and time
        }

        $query = "INSERT INTO sales (productID, quantitySold, salePrice, saleDate) 
                 VALUES (:productID, :quantitySold, :salePrice, :saleDate)";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':productID', $this->productID);
        $stmt->bindParam(':quantitySold', $this->quantitySold);
        $stmt->bindParam(':salePrice', $this->salePrice);
        $stmt->bindParam(':saleDate', $this->saleDate);
        
        try {
            if ($stmt->execute()) {
                // Update product quantity and mark as sold if quantity becomes 0
                $this->updateProductAfterSale();
                return ['success' => true];
            } else {
                return ['error' => 'Failed to create sale record'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function update($data = null) {
        if ($data) {
            $this->setSaleID($data['saleID']);
            $this->setProductID($data['productID']);
            $this->setQuantitySold($data['quantitySold']);
            $this->setSalePrice($data['salePrice']);
            $this->setSaleDate($data['saleDate']);
        }

        $query = "UPDATE sales 
                 SET productID = :productID, 
                     quantitySold = :quantitySold, 
                     salePrice = :salePrice, 
                     saleDate = :saleDate 
                 WHERE saleID = :saleID";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':saleID', $this->saleID);
        $stmt->bindParam(':productID', $this->productID);
        $stmt->bindParam(':quantitySold', $this->quantitySold);
        $stmt->bindParam(':salePrice', $this->salePrice);
        $stmt->bindParam(':saleDate', $this->saleDate);
        
        try {
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['error' => 'Failed to update sale record'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function delete($id) {
        $query = "DELETE FROM sales WHERE saleID = :saleID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':saleID', $id);
        
        try {
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['error' => 'Failed to delete sale record'];
            }
        } catch (PDOException $e) {
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    private function updateProductAfterSale() {
        // Get current product quantity
        $query = "SELECT quantity FROM products WHERE productID = :productID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':productID', $this->productID);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $newQuantity = $product['quantity'] - $this->quantitySold;
            $isSold = ($newQuantity <= 0) ? 1 : 0;

            // Update product quantity and sold status
            $updateQuery = "UPDATE products 
                           SET quantity = :quantity, 
                               isSold = :isSold 
                           WHERE productID = :productID";
            $updateStmt = $this->dbConnection->prepare($updateQuery);
            $updateStmt->bindParam(':quantity', $newQuantity);
            $updateStmt->bindParam(':isSold', $isSold);
            $updateStmt->bindParam(':productID', $this->productID);
            $updateStmt->execute();
        }
    }

    public function getSalesByDateRange($startDate, $endDate) {
        $query = "SELECT s.*, p.productName 
                 FROM sales s 
                 JOIN products p ON s.productID = p.productID 
                 WHERE s.saleDate BETWEEN :startDate AND :endDate 
                 ORDER BY s.saleDate DESC";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalSales() {
        $query = "SELECT SUM(salePrice) as totalSales FROM sales";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['totalSales'] ?? 0;
    }

    public function getTotalSalesByDateRange($startDate, $endDate) {
        $query = "SELECT SUM(salePrice) as totalSales 
                 FROM sales 
                 WHERE saleDate BETWEEN :startDate AND :endDate";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['totalSales'] ?? 0;
    }
}
?>
