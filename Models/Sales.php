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
    private $clientID;

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

    public function getClientID() {
        return $this->clientID;
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

    public function setClientID($clientID) {
        $this->clientID = $clientID;
        return $this;
    }

    // CRUD Operations
    public function read($id = null) {
        if ($id) {
            $query = "SELECT s.*, p.productName, c.clientName 
                     FROM sales s 
                     JOIN products p ON s.productID = p.productID 
                     JOIN clients c ON s.clientID = c.clientID
                     WHERE s.saleID = :saleID";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->bindParam(':saleID', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT s.*, p.productName, c.clientName 
                     FROM sales s 
                     JOIN products p ON s.productID = p.productID 
                     JOIN clients c ON s.clientID = c.clientID
                     ORDER BY s.saleDate DESC";
            $stmt = $this->dbConnection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function create($data = null) {
        if ($data) {
            $this->setProductID($data['productID']);
            $this->setClientID($data['clientID']);
            $this->setQuantitySold($data['quantitySold']);
            $this->setSalePrice($data['salePrice']);
            $this->setSaleDate(date('Y-m-d H:i:s')); // Current date and time
        }

        try {
            // Start transaction
            $this->dbConnection->beginTransaction();

            // Insert sale record
            $query = "INSERT INTO sales (productID, clientID, quantitySold, salePrice, saleDate) 
                     VALUES (:productID, :clientID, :quantitySold, :salePrice, :saleDate)";
            
            $stmt = $this->dbConnection->prepare($query);
            $stmt->bindParam(':productID', $this->productID);
            $stmt->bindParam(':clientID', $this->clientID);
            $stmt->bindParam(':quantitySold', $this->quantitySold);
            $stmt->bindParam(':salePrice', $this->salePrice);
            $stmt->bindParam(':saleDate', $this->saleDate);
            
            if (!$stmt->execute()) {
                throw new PDOException('Failed to create sale record');
            }

            // Update product quantity
            $updateQuery = "UPDATE products 
                           SET quantity = quantity - :quantitySold,
                               isSold = CASE 
                                   WHEN (quantity - :quantitySold) <= 0 THEN 1 
                                   ELSE 0 
                               END
                           WHERE productID = :productID";
            
            $updateStmt = $this->dbConnection->prepare($updateQuery);
            $updateStmt->bindParam(':quantitySold', $this->quantitySold);
            $updateStmt->bindParam(':productID', $this->productID);
            
            if (!$updateStmt->execute()) {
                throw new PDOException('Failed to update product quantity');
            }

            // Commit transaction
            $this->dbConnection->commit();
            return ['success' => true, 'saleID' => $this->dbConnection->lastInsertId()];

        } catch (PDOException $e) {
            // Rollback transaction on error
            $this->dbConnection->rollBack();
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

    public function getSalesByDateRange($startDate, $endDate) {
        $query = "SELECT s.*, p.productName, c.clientName 
                 FROM sales s 
                 JOIN products p ON s.productID = p.productID 
                 JOIN clients c ON s.clientID = c.clientID
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

    public function getAggregatedSales() {
        $query = "SELECT 
            p.productID,
            p.productName,
            p.category,
            SUM(s.quantitySold) AS unitsSold,
            MAX(s.salePrice) AS salePrice
        FROM sales s
        JOIN products p ON s.productID = p.productID
        GROUP BY p.productID, p.productName, p.category
        ORDER BY unitsSold DESC";
        
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRevenue() {
        $query = "SELECT SUM(quantitySold * salePrice) as totalRevenue FROM sales";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['totalRevenue'] ?? 0;
    }

    public function getTotalCosts() {
        $query = "SELECT SUM(s.quantitySold * p.paidPrice) as totalCosts
                 FROM sales s
                 JOIN products p ON s.productID = p.productID";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['totalCosts'] ?? 0;
    }

    public function getFinancialSummary() {
        $revenue = $this->getTotalRevenue();
        $costs = $this->getTotalCosts();
        $profit = $revenue - $costs;

        return [
            'revenue' => $revenue,
            'costs' => $costs,
            'profit' => $profit
        ];
    }
}
?>
