<?php
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';
require_once __DIR__ . '/../../../Controllers/ProductController.php';
require_once __DIR__ . '/../../../Models/product.php';

use controllers\ProductController;

$productController = new ProductController();
$categories = $productController->getCategories();

// Get product data if ID is provided
$product = null;
if (isset($_GET['id'])) {
    $product = $productController->getProduct($_GET['id']);
    if (isset($product['error'])) {
        echo "<script>alert('Error: " . $product['error'] . "'); window.location.href='manageInventory.php';</script>";
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['productId'])) {
        $data = [
            'productID' => $_POST['productId'],
            'productName' => $_POST['productName'],
            'category' => $_POST['category'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity']
        ];
        
        $result = $productController->updateProduct($data);
        if (isset($result['error'])) {
            echo "<script>alert('Error: " . $result['error'] . "');</script>";
        } else {
            header("Location: manageInventory.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Eyesightcollectibles</title>
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Menu Panel -->
        <div class="menu-panel">
            <h2 class="menu-title">Menu Panel</h2>
            <ul class="menu-items">
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/dashboard/home.php"><i class="fas fa-home"></i><span>Home</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/dashboard/manual.php"><i class="fas fa-book"></i><span>View Manual</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/settings/settings.php"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/users/users.php"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/product/manageInventory.php" class="active"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/product/soldProducts.php"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/product/archivedProducts.php"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/history/history.php"><i class="fas fa-history"></i><span>History</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/sales/sales.php"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="brand">Eyesightcollectibles</h1>
                <div class="welcome-text">Welcome Admin! <i class="fas fa-user-circle"></i></div>
            </div>

            <div class="add-product-container">
                <h2>Edit Product</h2>
                <form method="POST" action="" class="add-product-form">
                    <input type="hidden" name="productId" value="<?php echo htmlspecialchars($product['productID'] ?? ''); ?>">
                    
                    <div class="form-group">
                        <label for="productName">Product name</label>
                        <input type="text" id="productName" name="productName" required 
                               value="<?php echo htmlspecialchars($product['productName'] ?? ''); ?>"
                               placeholder="Enter product name">
                    </div>

                    <div class="form-group">
                        <label for="category">Product category</label>
                        <select id="category" name="category" required>
                            <?php foreach ($categories as $key => $value): ?>
                                <?php if ($key !== 'all'): ?>
                                    <option value="<?php echo $key; ?>" 
                                            <?php echo (isset($product['category']) && $product['category'] === $key) ? 'selected' : ''; ?>>
                                        <?php echo $value; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Product price</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required 
                               value="<?php echo htmlspecialchars($product['listedPrice'] ?? ''); ?>"
                               placeholder="Enter product price">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Product quantity</label>
                        <input type="number" id="quantity" name="quantity" min="0" required 
                               value="<?php echo htmlspecialchars($product['quantity'] ?? ''); ?>"
                               placeholder="Enter product quantity">
                    </div>

                    <div class="form-actions" style="display: flex; justify-content: space-between; gap: 10px;">
                        <a href="manageInventory.php" class="action-btn" style="background-color: transparent; color: #000; border: 1px solid #ddd;">Back</a>
                        <button type="submit" class="action-btn" style="background-color: transparent; color: #000; border: 1px solid #ddd;">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
