<?php
namespace resources\views\product;

require_once(__DIR__ . '/../../../lang/lang.php');

class ArchivedProducts {
    public function render($data) {
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo lang('archived_products'); ?> - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title"><?php echo lang('menu_panel'); ?></h2>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span><?php echo lang('home'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span><?php echo lang('view_manual'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive" class="active"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys"><i class="fas fa-history"></i><span><?php echo lang('history'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/salesCosts"><i class="fas fa-chart-line"></i><span><?php echo lang('sales_costs'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=auths/logout"><i class="fas fa-sign-out-alt"></i><span><?php echo lang('logout'); ?></span></a></li>
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <div class="header">
                        <h1 class="brand">Eyesightcollectibles</h1>
                        <div class="welcome-text"><?php echo lang('welcome') . ' ' . explode(' ', $_SESSION['userName'])[0]; ?>! <i class="fas fa-user-circle"></i></div>
                    </div>

                    <div class="inventory-container">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-error">
                                <?php 
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <?php 
                                    echo $_SESSION['success'];
                                    unset($_SESSION['success']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="archive-banner">
                            <h2><i class="fas fa-archive"></i> <?php echo lang('archive_banner'); ?></h2>
                            <p><?php echo lang('archive_banner_desc'); ?></p>
                        </div>

                        <!-- Search Bar -->
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchInput" class="search-bar" placeholder="<?php echo lang('search_archived_product_placeholder'); ?>">
                        </div>

                        <!-- Category Filters -->
                        <div class="category-filters">
                            <?php
                            $productController = new \Controllers\ProductController();
                            $categories = $productController->getCategories();
                            foreach ($categories as $value => $label) {
                                $activeClass = $value === 'all' ? ' active' : '';
                                echo "<button class=\"category-btn{$activeClass}\" data-category=\"{$value}\">{$label}</button>";
                            }
                            ?>
                        </div>

                        <!-- Products Table -->
                        <div class="table-container">
                            <table class="inventory-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" title="<?php echo lang('select_all'); ?>">
                                        </th>
                                        <th><?php echo lang('productid'); ?></th>
                                        <th><?php echo lang('product'); ?></th>
                                        <th><?php echo lang('category'); ?></th>
                                        <th><?php echo lang('price'); ?></th>
                                        <th><?php echo lang('quantity'); ?></th>
                                        <th><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="productTableBody">
                                    <?php if (isset($data['error'])): ?>
                                        <tr><td colspan="7"><?php echo lang('error_loading_archived_products'); ?>: <?php echo $data['error']; ?></td></tr>
                                    <?php else: ?>
                                        <?php foreach ($data as $product): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="product-checkbox" value="<?php echo $product['productID']; ?>" data-product-name="<?php echo htmlspecialchars($product['productName']); ?>">
                                                </td>
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
                                                            <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=products/unarchive" style="display: inline;" onsubmit="return confirmUnarchive('<?php echo htmlspecialchars($product['productName']); ?>')">
                                                                <input type="hidden" name="action" value="unarchive">
                                                                <input type="hidden" name="productId" value="<?php echo $product['productID']; ?>">
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="fas fa-box-open"></i> <?php echo lang('unarchive'); ?>
                                                                </button>
                                                            </form>
                                                            <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=products/delete" style="display: inline;" onsubmit="return confirmDelete('<?php echo htmlspecialchars($product['productName']); ?>')">
                                                                <input type="hidden" name="action" value="delete">
                                                                <input type="hidden" name="productId" value="<?php echo $product['productID']; ?>">
                                                                <input type="hidden" name="fromArchive" value="true">
                                                                <button type="submit" class="dropdown-item delete">
                                                                    <i class="fas fa-trash"></i> <?php echo lang('delete'); ?>
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

                        <!-- Bulk Actions -->
                        <div class="bulk-actions" style="display: none; margin-bottom: 20px;">
                            <div class="bulk-actions-container">
                                <div class="selected-count">
                                    <span id="selectedCount">0</span> <?php echo lang('items_selected'); ?>
                                </div>
                                <div class="bulk-buttons">
                                    <form id="bulkUnarchiveForm" method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=products/unarchive" style="display: inline;">
                                        <input type="hidden" name="action" value="bulkUnarchive">
                                        <input type="hidden" name="productIds" id="bulkUnarchiveIds">
                                        <button type="submit" class="action-btn unarchive-btn" onclick="return handleBulkUnarchive()">
                                            <i class="fas fa-box-open"></i> <?php echo lang('unarchive_selected'); ?>
                                        </button>
                                    </form>
                                    <form id="bulkDeleteForm" method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=products/delete" style="display: inline;">
                                        <input type="hidden" name="action" value="bulkDelete">
                                        <input type="hidden" name="productIds" id="bulkDeleteIds">
                                        <input type="hidden" name="fromArchive" value="true">
                                        <button type="submit" class="action-btn delete-btn" onclick="return handleBulkDelete()">
                                            <i class="fas fa-trash"></i> <?php echo lang('delete_selected'); ?>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function confirmUnarchive(productName) {
                    return confirm('<?php echo lang('confirm_unarchive'); ?>'.replace('{product}', productName));
                }

                function confirmDelete(productName) {
                    return confirm('<?php echo lang('confirm_delete'); ?>'.replace('{product}', productName));
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
                            const productName = row.children[2].textContent.toLowerCase();
                            const productCategory = normalizeCategory(row.children[3].textContent);
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

                // Select All functionality
                document.getElementById('selectAll').addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.product-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateBulkActionsVisibility();
                    updateSelectedCount();
                });

                // Individual checkbox change handler
                document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateBulkActionsVisibility();
                        updateSelectedCount();
                    });
                });

                // Update bulk actions visibility
                function updateBulkActionsVisibility() {
                    const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
                    const bulkActions = document.querySelector('.bulk-actions');
                    bulkActions.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
                }

                // Update selected count
                function updateSelectedCount() {
                    const count = document.querySelectorAll('.product-checkbox:checked').length;
                    document.getElementById('selectedCount').textContent = count;
                }

                // Handle bulk unarchive
                function handleBulkUnarchive() {
                    const selectedProducts = getSelectedProducts();
                    if (selectedProducts.length === 0) {
                        alert('<?php echo lang('please_select_products_unarchive'); ?>');
                        return false;
                    }

                    const productNames = selectedProducts.map(p => p.name).join('", "');
                    const confirmMessage = '<?php echo lang('confirm_bulk_unarchive'); ?>'.replace('{products}', productNames);
                    
                    if (confirm(confirmMessage)) {
                        document.getElementById('bulkUnarchiveIds').value = JSON.stringify(selectedProducts.map(p => p.id));
                        return true;
                    }
                    return false;
                }

                // Handle bulk delete
                function handleBulkDelete() {
                    const selectedProducts = getSelectedProducts();
                    if (selectedProducts.length === 0) {
                        alert('<?php echo lang('please_select_products'); ?>'.replace('{action}', '<?php echo lang('delete'); ?>'));
                        return false;
                    }

                    const productNames = selectedProducts.map(p => p.name).join('", "');
                    const confirmMessage = '<?php echo lang('confirm_bulk_delete'); ?>'.replace('{products}', productNames);
                    
                    if (confirm(confirmMessage)) {
                        document.getElementById('bulkDeleteIds').value = JSON.stringify(selectedProducts.map(p => p.id));
                        return true;
                    }
                    return false;
                }

                // Get selected products
                function getSelectedProducts() {
                    const checkboxes = document.querySelectorAll('.product-checkbox:checked');
                    return Array.from(checkboxes).map(checkbox => ({
                        id: checkbox.value,
                        name: checkbox.dataset.productName
                    }));
                }
            </script>
        </body>
        </html>
        <?php
    }
}
