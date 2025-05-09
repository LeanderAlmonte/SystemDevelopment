<?php
namespace Resources\Views\Product;

class SoldProducts {
    public function render($data = null) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Sold Products - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title">Menu Panel</h2>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span>Home</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span>User Manual</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts" class="active"><i class="fas fa-shopping-cart"></i><span>Sold Products</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys"><i class="fas fa-history"></i><span>History</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/salesCosts"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=auths/logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <div class="header">
                        <h1 class="brand">Eyesightcollectibles</h1>
                        <div class="welcome-text">Welcome <?php echo explode(' ', $_SESSION['userName'])[0]; ?>! <i class="fas fa-user-circle"></i></div>
                    </div>

                    <div class="inventory-container">
                        <div class="inventory-header">
                            <div class="header-content">
                                <h2><i class="fas fa-shopping-cart"></i> Sold Products</h2>
                                <p>View all sold products in your inventory</p>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchInput" class="search-bar" placeholder="Search for product by name">
                        </div>

                        <!-- Category Filters -->
                        <div class="category-filters">
                            <button class="category-btn active" data-category="all">All Products</button>
                            <button class="category-btn" data-category="pokemon-japanese">Pokemon Japanese</button>
                            <button class="category-btn" data-category="pokemon-korean">Pokemon Korean</button>
                            <button class="category-btn" data-category="pokemon-chinese">Pokemon Chinese</button>
                            <button class="category-btn" data-category="card-accessories">Card Accessories</button>
                            <button class="category-btn" data-category="weiss-schwarz">Weiss Schwarz</button>
                            <button class="category-btn" data-category="kayou-naruto">Kayou Naruto</button>
                            <button class="category-btn" data-category="kayou">Kayou</button>
                            <button class="category-btn" data-category="dragon-ball-japanese">Dragon Ball Japanese</button>
                            <button class="category-btn" data-category="one-piece-japanese">One Piece Japanese</button>
                            <button class="category-btn" data-category="carreda-demon-slayer">Carreda Demon Slayer</button>
                            <button class="category-btn" data-category="pokemon-plush">Pokemon Plush</button>
                        </div>

                        <div class="table-container">
                            <table class="inventory-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Total Units Sold</th>
                                        <th>Sale Price</th>
                                    </tr>
                                </thead>
                                <tbody id="productTableBody">
                                    <?php if (isset($data) && !empty($data)): ?>
                                        <?php foreach ($data as $product): ?>
                                            <tr>
                                                <td>#<?php echo htmlspecialchars($product['productID']); ?></td>
                                                <td><?php echo htmlspecialchars($product['productName']); ?></td>
                                                <td><?php 
                                                    $productController = new \Controllers\ProductController();
                                                    $categories = $productController->getCategories();
                                                    echo $categories[$product['category']] ?? $product['category'];
                                                ?></td>
                                                <td><?php echo $product['unitsSold']; ?></td>
                                                <td>$<?php echo number_format($product['salePrice'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="no-data">No sales records found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .inventory-header {
                    background-color: var(--primary-color);
                    color: var(--white);
                    padding: 15px 20px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                .header-content {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    width: 100%;
                }

                .header-content h2 {
                    margin: 0;
                    font-size: 20px;
                    color: var(--white);
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .header-content h2 i {
                    font-size: 18px;
                }

                .header-content p {
                    margin: 0;
                    font-size: 14px;
                    opacity: 0.9;
                }

                .table-container {
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    overflow-x: auto;
                }

                .inventory-table {
                    width: 100%;
                    border-collapse: collapse;
                    min-width: 800px;
                }

                .inventory-table th,
                .inventory-table td {
                    padding: 12px 15px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                }

                .inventory-table th {
                    background-color: #f8f9fa;
                    font-weight: 600;
                    color: #333;
                }

                .inventory-table tr:hover {
                    background-color:#E86C2C;
                }

                .inventory-table td:first-child {
                    font-weight: 500;
                    color: black;
                }

                .inventory-table td:nth-child(4) {
                    font-weight: 500;
                    color: #2196F3;
                }

                .inventory-table td:last-child {
                    font-weight: 500;
                    color: #4CAF50;
                }

                .no-data {
                    text-align: center;
                    color: #666;
                    padding: 20px;
                }

                .main-content {
                    background-color: #f4f4f4;
                    min-height: 100vh;
                }

            </style>

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
                            const categoryMatch = category === 'all' || productCategory === category;
                            
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
        <?php
    }
}
