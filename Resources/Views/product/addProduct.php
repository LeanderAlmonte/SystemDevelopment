<?php
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';
require_once __DIR__ . '/../../../Controllers/ProductController.php';
require_once __DIR__ . '/../../../Models/product.php';

use controllers\ProductController;

$productController = new ProductController();
$categories = $productController->getCategories();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $productController->addProduct($_POST);
    if (isset($result['error'])) {
        $error = $result['error'];
    } else {
        header('Location: manageInventory.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Eyesightcollectibles</title>
    <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
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
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/product/archivedItems.php"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
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
                <h2>New Product</h2>
                <?php if (isset($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" class="add-product-form">
                    <div class="form-group">
                        <label for="productName">Product name</label>
                        <input type="text" id="productName" name="productName" placeholder="Product name" required>
                    </div>

                    <div class="form-group">
                        <label for="listedPrice">Product price</label>
                        <input type="number" id="listedPrice" name="listedPrice" step="0.01" placeholder="Product price" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Product category</label>
                        <select id="category" name="category" required>
                            <option value="" disabled selected>Product category</option>
                            <?php foreach ($categories as $key => $value): ?>
                                <?php if ($key !== 'all'): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Product quantity</label>
                        <input type="number" id="quantity" name="quantity" min="0" max="100" placeholder="Product quantity" required>
                    </div>

                    <div class="form-group">
                        <label for="paidPrice">Product cost</label>
                        <input type="number" id="paidPrice" name="paidPrice" step="0.01" placeholder="Product cost" required>
                    </div>

                    <div class="form-actions">
                        <button type="button" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/Resources/Views/product/manageInventory.php'">Back</button>
                        <button type="submit">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
