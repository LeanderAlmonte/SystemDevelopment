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
}
