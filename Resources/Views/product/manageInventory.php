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
    <!-- <base href="/ecommerce/Project/SystemDevelopment/"> -->
    <link rel="stylesheet" href="../../../assets/css/styles.css">
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
                                                    <a href="#" class="dropdown-item" onclick="archiveProduct(<?php echo $product['productID']; ?>)">
                                                        <i class="fas fa-archive"></i> Archive
                                                    </a>
                                                    <a href="#" class="dropdown-item">
                                                        <i class="fas fa-edit"></i> Edit
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

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="action-btn" id="processOrderBtn">Process Order</button>
                    <form action="addProduct.php" method="GET">
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

        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                var formData = new FormData();
                formData.append('productId', productId);

                fetch('/ecommerce/Project/SystemDevelopment/Resources/Views/product/deleteProduct.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        var row = document.querySelector(`button[onclick="toggleDropdown(this, ${productId})"]`).closest('tr');
                        row.remove();
                    } else {
                        alert('Error deleting product: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting product. Please check the console for details.');
                });
            }
        }

        function archiveProduct(productId) {
            if (confirm('Are you sure you want to archive this product?')) {
                fetch('/ecommerce/Project/SystemDevelopment/Resources/Views/product/archivedProducts.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=archive&productId=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`button[onclick="toggleDropdown(this, ${productId})"]`).closest('tr');
                        row.remove();
                    } else {
                        alert('Error archiving product: ' + (data.error || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error archiving product');
                });
            }
        }
    </script>
</body>
</html>
