<?php

namespace Controllers;

use Models\Product;
use Models\Sales;
use Models\User;
use Models\Client;
use Resources\Views\Product\ManageInventory;
use Resources\Views\Product\AddProduct;
use Resources\Views\Product\EditProduct;
use Resources\Views\Product\ArchivedProducts;
use Resources\Views\Product\SoldProducts;
use Resources\Views\Product\ProcessOrder;

require(dirname(__DIR__) . '/Resources/Views/Product/ManageInventory.php');
require(dirname(__DIR__) . '/Resources/Views/Product/AddProduct.php');
require(dirname(__DIR__) . '/Resources/Views/Product/EditProduct.php');
require(dirname(__DIR__) . '/Resources/Views/Product/ArchivedProducts.php');
require(dirname(__DIR__) . '/Resources/Views/Product/SoldProducts.php');
require(dirname(__DIR__) . '/Resources/Views/Product/ProcessOrder.php');
require(dirname(__DIR__) . '/Models/Product.php');
require(dirname(__DIR__) . '/Models/Sales.php');
require(dirname(__DIR__) . '/Models/User.php');
require(dirname(__DIR__) . '/Models/Client.php');

class ProductController {
    private Product $product;
    private Sales $sales;
    private User $user;
    private Client $client;

    public function __construct() {
        $this->product = new Product();
        $this->sales = new Sales();
        $this->user = new User();
        $this->client = new Client();
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

    public function soldProducts() {
        $data = $this->sales->getAggregatedSales();
        $soldProducts = new SoldProducts();
        $soldProducts->render($data);
    }

    public function processOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productID = $_POST['productID'] ?? null;
            $clientID = $_POST['clientID'] ?? null;
            $quantitySold = $_POST['quantitySold'] ?? null;
            $salePrice = $_POST['salePrice'] ?? null;

            if (!$productID || !$clientID || !$quantitySold || !$salePrice) {
                $_SESSION['error'] = "All fields are required";
                header("Location: /ecommerce/Project/SystemDevelopment/index.php?url=products/processOrder");
                exit;
            }

            // Validate quantity
            $product = $this->product->read($productID);
            if (!$product) {
                $_SESSION['error'] = "Product not found";
                header("Location: /ecommerce/Project/SystemDevelopment/index.php?url=products/processOrder");
                exit;
            }

            if ($quantitySold > $product['quantity']) {
                $_SESSION['error'] = "Quantity exceeds available stock";
                header("Location: /ecommerce/Project/SystemDevelopment/index.php?url=products/processOrder");
                exit;
            }

            // Create sale record
            $saleData = [
                'productID' => $productID,
                'clientID' => $clientID,
                'quantitySold' => $quantitySold,
                'salePrice' => $salePrice
            ];

            $result = $this->sales->create($saleData);

            if (isset($result['error'])) {
                $_SESSION['error'] = $result['error'];
            } else {
                $_SESSION['success'] = "Order processed successfully";
                header("Location: /ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts");
                exit;
            }
        }

        // Get all products and clients for the form
        $products = $this->product->read();
        $clients = $this->client->read();
        
        $processOrder = new ProcessOrder();
        $processOrder->render([
            'products' => $products,
            'clients' => $clients
        ]);
    }
}
