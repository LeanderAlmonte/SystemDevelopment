<?php

namespace Controllers;

use Models\Product;
use Resources\Views\Product\ManageInventory;
use Resources\Views\Product\AddProduct;
use Resources\Views\Product\EditProduct;
use Resources\Views\Product\ArchivedProducts;

require(dirname(__DIR__) . '/Resources/Views/Product/ManageInventory.php');
require(dirname(__DIR__) . '/Resources/Views/Product/AddProduct.php');
require(dirname(__DIR__) . '/Resources/Views/Product/EditProduct.php');
require(dirname(__DIR__) . '/Resources/Views/Product/ArchivedProducts.php');
require(dirname(__DIR__) . '/Models/Product.php');

class ProductController {
    private Product $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function read() {
        $data = $this->product->read();
        $manageInventory = new ManageInventory();
        $manageInventory->render($data);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->product->create($_POST);
            if (isset($result['error'])) {
                $error = $result['error'];
                $this->showAddForm($error);
            } else {
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=products');
                exit();
            }
        } else {
            $this->showAddForm();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->product->update($_POST);
            if (isset($result['error'])) {
                $error = $result['error'];
                $this->showEditForm($_POST['productID'], $error);
            } else {
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=products');
                exit();
            }
        } else {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $this->showEditForm($id);
            }
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['productId'] ?? null;
            if ($id) {
                $result = $this->product->delete($id);
                if (isset($result['error'])) {
                    echo "<script>alert('Error: " . $result['error'] . "');</script>";
                }
            }
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=products');
            exit();
        }
    }

    public function archive() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['productId'] ?? null;
            if ($id) {
                $result = $this->product->archive($id);
                if (isset($result['error'])) {
                    echo "<script>alert('Error: " . $result['error'] . "');</script>";
                }
            }
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=products');
            exit();
        } else {
            $data = $this->product->getArchivedProducts();
            $archivedProducts = new ArchivedProducts();
            $archivedProducts->render($data);
        }
    }

    public function unarchive() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['productId'] ?? null;
            if ($id) {
                $result = $this->product->unarchive($id);
                if (isset($result['error'])) {
                    echo "<script>alert('Error: " . $result['error'] . "');</script>";
                }
            }
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=products/archive');
            exit();
        }
    }

    private function showAddForm($error = null) {
        $addProduct = new AddProduct();
        $addProduct->render($error);
        exit();
    }

    private function showEditForm($id, $error = null) {
        $product = $this->product->read($id);
        if ($product) {
            $editProduct = new EditProduct();
            $editProduct->render(['product' => $product], $error);
        } else {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=products');
        }
        exit();
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
