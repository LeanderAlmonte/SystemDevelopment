<?php
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';
require_once __DIR__ . '/../../../Controllers/ProductController.php';
require_once __DIR__ . '/../../../Models/product.php';

use controllers\ProductController;

$productController = new ProductController();
$products = $productController->index();
$categories = $productController->getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory - Eyesightcollectibles</title>
    <base href="/ecommerce/Project/SystemDevelopment/">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Menu Panel -->
        <div class="menu-panel">
            <h2 class="menu-title">Menu Panel</h2>
            <ul class="menu-items">
                <li><a href="Resources/Views/dashboard/home.php"><i class="fas fa-home"></i><span>Home</span></a></li>
                <li><a href="Resources/Views/dashboard/manual.php"><i class="fas fa-book"></i><span>View Manual</span></a></li>
                <li><a href="Resources/Views/settings/settings.php"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                <li><a href="Resources/Views/users/users.php"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                <li><a href="Resources/Views/product/manageInventory.php" class="active"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                <li><a href="Resources/Views/product/soldProducts.php"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
                <li><a href="Resources/Views/product/archivedItems.php"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                <li><a href="Resources/Views/history/history.php"><i class="fas fa-history"></i><span>History</span></a></li>
                <li><a href="Resources/Views/sales/sales.php"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="brand">Eyesightcollectibles</h1>
                <div class="welcome-text">Welcome Admin! <i class="fas fa-user-circle"></i></div>
            </div>

            <div class="inventory-container">
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
                                        <td>#<?php echo $product['productID']; ?></td>
                                        <td><?php echo $product['productName']; ?></td>
                                        <td><?php echo $product['category']; ?></td>
                                        <td>$<?php echo $product['price']; ?></td>
                                        <td><?php echo $product['quantity']; ?>/100</td>
                                        <td><button class='action-btn'><i class='fas fa-ellipsis-h'></i></button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="action-btn" id="processOrderBtn">Process Order</button>
                    <form action="Resources/Views/product/addProduct.php" method="GET" style="display: inline;">
                        <button type="submit" class="action-btn">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categoryBtns = document.querySelectorAll('.category-btn');
            const productTableBody = document.getElementById('productTableBody');

            // Function to normalize category names for comparison
            function normalizeCategory(category) {
                return category.toLowerCase().replace(/\s+/g, '-');
            }

            // Function to filter products based on category and search term
            function filterProducts(category, searchTerm) {
                const rows = productTableBody.querySelectorAll('tr');
                
                rows.forEach(row => {
                    const productName = row.children[1].textContent.toLowerCase();
                    const productCategory = normalizeCategory(row.children[2].textContent);
                    const searchMatch = productName.includes(searchTerm.toLowerCase());
                    const categoryMatch = category === 'all' || productCategory.includes(category);
                    
                    row.style.display = searchMatch && categoryMatch ? '' : 'none';
                });
            }

            // Search functionality
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value;
                const activeCategory = document.querySelector('.category-btn.active').dataset.category;
                filterProducts(activeCategory, searchTerm);
            });

            // Category filter functionality
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update active state
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Filter products
                    const category = this.dataset.category;
                    const searchTerm = searchInput.value;
                    filterProducts(category, searchTerm);
                });
            });

            // Initial filter
            filterProducts('all', '');
        });
    </script>
</body>
</html>
