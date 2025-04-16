<?php

namespace models;

use database\DBConnectionManager;
use PDO;

class Product {
    private $db;
    private $productID;
    private $productType;
    private $productName;
    private $language;
    private $listedPrice;
    private $paidPrice;
    private $quantity;
    private $category;

    public function __construct() {
        $dbManager = new DBConnectionManager();
        $this->db = $dbManager->getConnection();
    }

    // Getters and Setters
    public function getProductID() {
        return $this->productID;
    }

    public function setProductID($productID) {
        $this->productID = $productID;
    }

    public function getProductType() {
        return $this->productType;
    }

    public function setProductType($productType) {
        $this->productType = $productType;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }

    public function getListedPrice() {
        return $this->listedPrice;
    }

    public function setListedPrice($listedPrice) {
        $this->listedPrice = $listedPrice;
    }

    public function getPaidPrice() {
        return $this->paidPrice;
    }

    public function setPaidPrice($paidPrice) {
        $this->paidPrice = $paidPrice;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    // Database Operations
    public function getAllProducts() {
        try {
            $query = "SELECT productID, productName, category, listedPrice as price, quantity FROM products WHERE isArchived = 0";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getProductById($id) {
        try {
            $query = "SELECT * FROM products WHERE productID = :id AND isArchived = 0";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateProduct($data) {
        try {
            $query = "UPDATE products SET 
                     productName = :name,
                     category = :category,
                     listedPrice = :price,
                     quantity = :quantity
                     WHERE productID = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':name' => $data['productName'],
                ':category' => $data['category'],
                ':price' => $data['price'],
                ':quantity' => $data['quantity'],
                ':id' => $data['productID']
            ]);
            return true;
        } catch (\PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}


?>