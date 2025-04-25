<?php
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';
require_once __DIR__ . '/../../../Controllers/ProductController.php';
require_once __DIR__ . '/../../../Models/product.php';

use controllers\ProductController;

$productController = new ProductController();
$categories = $productController->getCategories();
$products = $productController->getArchivedProducts();

// Handle archive/unarchive requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
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

    echo json_encode(['error' => 'Invalid request']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Products - Eyesightcollectibles</title>
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
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/product/manageInventory.php"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/product/soldProducts.php"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/product/archivedProducts.php" class="active"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
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

            <div class="inventory-container">
                <div class="archive-banner">
                    <h2><i class="fas fa-archive"></i> Archived Products</h2>
                    <p>These products are not visible in the main inventory</p>
                </div>

                <!-- Search Bar -->
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" class="search-bar" placeholder="Search for product by product name">
                </div>

                <!-- Category Filters -->
                <div class="category-filters">
                    <?php foreach ($categories as $key => $value): ?>
                        <button class="category-btn <?php echo $key === 'all' ? 'active' : ''; ?>" data-category="<?php echo $key; ?>"><?php echo $value; ?></button>
                    <?php endforeach; ?>
                </div>

                <!-- Products Table -->
                <div class="table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>ProductID</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody">
                            <?php if (isset($products['error'])): ?>
                                <tr><td colspan="6">Error loading products: <?php echo $products['error']; ?></td></tr>
                            <?php else: ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['productID']); ?></td>
                                        <td><?php echo htmlspecialchars($product['productName']); ?></td>
                                        <td><?php echo htmlspecialchars($categories[$product['category']] ?? $product['category']); ?></td>
                                        <td>$<?php echo htmlspecialchars($product['price']); ?></td>
                                        <td><?php echo htmlspecialchars($product['quantity']); ?>/100</td>
                                        <td class="actions-cell">
                                            <div class="dropdown">
                                                <button class="action-btn" onclick="toggleDropdown(this, <?php echo $product['productID']; ?>)">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div id="dropdown-<?php echo $product['productID']; ?>" class="dropdown-content">
                                                    <a href="#" class="dropdown-item" onclick="unarchiveProduct(<?php echo $product['productID']; ?>)">
                                                        <i class="fas fa-box"></i> Unarchive
                                                    </a>
                                                    <a href="#" class="dropdown-item delete" onclick="deleteProduct(<?php echo $product['productID']; ?>)">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ... Same filtering and dropdown code as manageInventory.php ...

        function unarchiveProduct(productId) {
            if (confirm('Are you sure you want to unarchive this product?')) {
                fetch('/ecommerce/Project/SystemDevelopment/Resources/Views/product/archiveProduct.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=unarchive&productId=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`button[onclick="toggleDropdown(this, ${productId})"]`).closest('tr');
                        row.remove();
                    } else {
                        alert('Error unarchiving product: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error unarchiving product');
                });
            }
        }

        // ... Rest of the JavaScript code ...
    </script>
</body>
</html>
