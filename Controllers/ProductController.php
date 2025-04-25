<?php

namespace controllers;

use models\Product;
use database\DBConnectionManager;

class ProductController {
    private $db;
    private $productModel;

    public function __construct() {
        $dbManager = new DBConnectionManager();
        $this->db = $dbManager->getConnection();
        $this->productModel = new Product();
    }

    public function index() {
        return $this->productModel->getAllProducts();
    }

    public function getProduct($id) {
        return $this->productModel->getProductById($id);
    }

    public function addProduct($data) {
        // Validate input
        if (empty($data['productName']) || empty($data['category']) || 
            empty($data['listedPrice']) || empty($data['paidPrice']) || 
            !isset($data['quantity'])) {
            return ['error' => 'All fields are required'];
        }

        // Validate price and quantity
        if (!is_numeric($data['listedPrice']) || $data['listedPrice'] <= 0) {
            return ['error' => 'Invalid listed price'];
        }
        if (!is_numeric($data['paidPrice']) || $data['paidPrice'] <= 0) {
            return ['error' => 'Invalid paid price'];
        }
        if (!is_numeric($data['quantity']) || $data['quantity'] < 0 || $data['quantity'] > 100) {
            return ['error' => 'Quantity must be between 0 and 100'];
        }

        return $this->productModel->addProduct($data);
    }

    public function updateProduct($data) {
        return $this->productModel->updateProduct($data);
    }

    public function getCategories() {
        return [
            'all' => 'All Products',
            'pokemon-japanese' => 'Pokemon Japanese',
            'pokemon-korean' => 'Pokemon Korean',
            'pokemon-chinese' => 'Pokemon Chinese',
            'card-accessories' => 'Card Accessories',
            'weiss-schwarz' => 'Weiss Schwarz',
            'kayou-naruto' => 'Kayou Naruto',
            'kayou' => 'Kayou',
            'dragon-ball-japanese' => 'Dragon Ball Japanese',
            'one-piece-japanese' => 'One Piece Japanese',
            'carreda-demon-slayer' => 'Carreda Demon Slayer',
            'pokemon-plush' => 'Pokemon Plush'
        ];
    }

    public function deleteProduct($id) {
        if (!is_numeric($id)) {
            return ['error' => 'Invalid product ID'];
        }
        return $this->productModel->deleteProduct($id);
    }
}
