<?php
namespace resources\views\product;

class ManageInventory {
    public function render($data) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Manage Inventory - Eyesightcollectibles</title>
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
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span>View Manual</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products" class="active"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=history"><i class="fas fa-history"></i><span>History</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=sales"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
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
                                    <?php if (isset($data['error'])): ?>
                                        <tr><td colspan="6">Error loading products: <?php echo $data['error']; ?></td></tr>
                                    <?php else: ?>
                                        <?php foreach ($data as $product): ?>
                                            <tr>
                                                <td>#<?php echo $product['productID']; ?></td>
                                                <td><?php echo $product['productName']; ?></td>
                                                <td><?php 
                                                    $productController = new \Controllers\ProductController();
                                                    $categories = $productController->getCategories();
                                                    echo $categories[$product['category']] ?? $product['category'];
                                                ?></td>
                                                <td>$<?php echo $product['listedPrice']; ?></td>
                                                <td><?php echo $product['quantity']; ?></td>
                                                <td class="actions-cell">
                                                    <div class="dropdown">
                                                        <button class="action-btn" onclick="toggleDropdown(this, <?php echo $product['productID']; ?>)">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <div id="dropdown-<?php echo $product['productID']; ?>" class="dropdown-content">
                                                            <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive" style="display: inline;" onsubmit="return confirmArchive('<?php echo htmlspecialchars($product['productName']); ?>')">
                                                                <input type="hidden" name="action" value="archive">
                                                                <input type="hidden" name="productId" value="<?php echo $product['productID']; ?>">
                                                                <button type="submit" class="dropdown-item" style="background: none; border: none; width: 100%; text-align: left; padding: 8px 16px; cursor: pointer;">
                                                                    <i class="fas fa-archive"></i> Archive
                                                                </button>
                                                            </form>
                                                            <a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/update&id=<?php echo $product['productID']; ?>" class="dropdown-item">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=products/delete" style="display: inline;" onsubmit="return confirmDelete('<?php echo htmlspecialchars($product['productName']); ?>')">
                                                                <input type="hidden" name="action" value="delete">
                                                                <input type="hidden" name="productId" value="<?php echo $product['productID']; ?>">
                                                                <button type="submit" class="dropdown-item delete" style="background: none; border: none; width: 100%; text-align: left; padding: 8px 16px; cursor: pointer;">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </button>
                                                            </form>
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
                            <a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/create" class="action-btn">Add Product</a>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function confirmArchive(productName) {
                    return confirm('Are you sure you want to archive "' + productName + '"?');
                }

                function confirmDelete(productName) {
                    return confirm('Are you sure you want to delete "' + productName + '"? This action cannot be undone.');
                }

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
        <?php
    }
}
