<?php
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';
require_once __DIR__ . '/../../../Controllers/ProductController.php';
require_once __DIR__ . '/../../../Models/product.php';

use controllers\ProductController;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productController = new ProductController();
    
    if (isset($_POST['productId'])) {
        $action = $_POST['action'] ?? 'archive';
        $productId = $_POST['productId'];

        if ($action === 'archive') {
            $result = $productController->archiveProduct($productId);
        } else {
            $result = $productController->unarchiveProduct($productId);
        }

        echo json_encode($result);
        exit();
    }
}

echo json_encode(['error' => 'Invalid request']);
?> 