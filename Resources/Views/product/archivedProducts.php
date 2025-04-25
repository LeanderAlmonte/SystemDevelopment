<?php
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';
require_once __DIR__ . '/../../../Controllers/ProductController.php';
require_once __DIR__ . '/../../../Models/product.php';

use controllers\ProductController;

$productController = new ProductController();
$categories = $productController->getCategories();

// Handle archive/unarchive requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['productId']) && isset($_POST['action'])) {
        $action = $_POST['action'];
        $productId = $_POST['productId'];

        if ($action === 'unarchive') {
            $result = $productController->unarchiveProduct($productId);
            if (isset($result['error'])) {
                echo "<script>alert('Error: " . $result['error'] . "');</script>";
            } else {
                // Refresh the page to show updated list
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    }
}

$products = $productController->getArchivedProducts();
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
                                                    <form method="POST" action="" style="display: inline;">
                                                        <input type="hidden" name="action" value="unarchive">
                                                        <input type="hidden" name="productId" value="<?php echo $product['productID']; ?>">
                                                        <button type="submit" class="dropdown-item" style="background: none; border: none; width: 100%; text-align: left; padding: 8px 16px; cursor: pointer;">
                                                            <i class="fas fa-box"></i> Unarchive
                                                        </button>
                                                    </form>
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

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                const dropdowns = document.querySelectorAll('.dropdown-content');
                dropdowns.forEach(dropdown => dropdown.classList.remove('show'));
            }
        });

        // Close dropdowns when scrolling
        document.querySelector('.table-container').addEventListener('scroll', function() {
            const dropdowns = document.querySelectorAll('.dropdown-content');
            dropdowns.forEach(dropdown => dropdown.classList.remove('show'));
        });

        function toggleDropdown(button, productId) {
            const dropdowns = document.querySelectorAll('.dropdown-content');
            dropdowns.forEach(dropdown => {
                if (dropdown.id !== `dropdown-${productId}`) {
                    dropdown.classList.remove('show');
                }
            });
            
            const dropdown = document.getElementById(`dropdown-${productId}`);
            if (!dropdown.classList.contains('show')) {
                const rect = button.getBoundingClientRect();
                dropdown.style.left = `${rect.left}px`;
                
                // Calculate if there's enough space above
                const spaceAbove = rect.top;
                const spaceBelow = window.innerHeight - rect.bottom;
                const dropdownHeight = 150; // Approximate height of dropdown
                
                if (spaceAbove > dropdownHeight || spaceAbove > spaceBelow) {
                    // Show above
                    dropdown.style.top = `${rect.top}px`;
                } else {
                    // Show below
                    dropdown.style.top = `${rect.bottom}px`;
                }
            }
            dropdown.classList.toggle('show');
        }
    </script>
</body>
</html>
