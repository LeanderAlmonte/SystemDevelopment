<?php
namespace Resources\Views\History;

require_once(__DIR__ . '/../../../lang/lang.php');

class History {
    public function render($data = null) {
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo lang('action_history'); ?> - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title"><?php echo lang('menu_panel'); ?></h2>
                    <?php $role = $_SESSION['userRole'] ?? 'Admin'; ?>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span><?php echo lang('home'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span><?php echo lang('view_manual'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                        <?php if ($role === 'Admin'): ?>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys" class="active"><i class="fas fa-history"></i><span><?php echo lang('history'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/salesCosts"><i class="fas fa-chart-line"></i><span><?php echo lang('sales_costs'); ?></span></a></li>
                        <?php endif; ?>
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
                        <div class="inventory-header">
                            <div class="header-content">
                                <h2><i class="fas fa-history"></i> <?php echo lang('action_history'); ?></h2>
                                <p><?php echo lang('view_system_actions'); ?></p>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchInput" class="search-bar" placeholder="<?php echo lang('search_action_placeholder'); ?>">
                        </div>

                        <!-- Action Type Filters -->
                        <div class="category-filters">
                            <button class="category-btn active" data-category="all"><?php echo lang('all_actions'); ?></button>
                            <button class="category-btn" data-category="ADD"><?php echo lang('add'); ?></button>
                            <button class="category-btn" data-category="UPDATE"><?php echo lang('update'); ?></button>
                            <button class="category-btn" data-category="DELETE"><?php echo lang('delete'); ?></button>
                            <button class="category-btn" data-category="ARCHIVE"><?php echo lang('archive'); ?></button>
                            <button class="category-btn" data-category="UNARCHIVE"><?php echo lang('unarchive'); ?></button>
                            <button class="category-btn" data-category="SALE"><?php echo lang('sale'); ?></button>
                        </div>

                        <div class="table-container">
                            <table class="inventory-table">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('timestamp'); ?></th>
                                        <th><?php echo lang('user_id'); ?></th>
                                        <th><?php echo lang('product_id'); ?></th>
                                        <th><?php echo lang('quantity'); ?></th>
                                        <th><?php echo lang('action_type'); ?></th>
                                        <th><?php echo lang('description'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="actionTableBody">
                                    <?php if ($data && is_array($data)): ?>
                                        <?php foreach ($data as $action): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($action['timeStamp']); ?></td>
                                            <td><?php echo htmlspecialchars($action['userID']); ?></td>
                                            <td><?php echo htmlspecialchars($action['productID']); ?></td>
                                            <td><?php echo htmlspecialchars($action['quantity']); ?></td>
                                            <td><?php echo htmlspecialchars($action['actionType']); ?></td>
                                            <td>
                                                <button type="button" 
                                                        class="description-btn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#actionDetailsModal"
                                                        data-description="<?php echo htmlspecialchars($action['description']); ?>"
                                                        data-old-value="<?php echo htmlspecialchars($action['oldValue']); ?>"
                                                        data-new-value="<?php echo htmlspecialchars($action['newValue']); ?>">
                                                    <?php echo lang('view'); ?>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="no-data"><?php echo lang('no_actions_found'); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Modal for all actions -->
            <div class="modal fade" id="actionDetailsModal" tabindex="-1" aria-labelledby="actionDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="actionDetailsModalLabel"><?php echo lang('action_details'); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo lang('close'); ?>"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <strong><?php echo lang('description'); ?>:</strong>
                                <p class="modal-description"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
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

                /* .inventory-table tr:hover {
                    background-color: #E86C2C;
                } */

                .description-btn {
                    padding: 2px 8px;
                    font-size: 0.9rem;
                    background-color: #E86C2C;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }

                .description-btn:hover {
                    background-color: #d15a1a;
                }

                .close-btn {
                    background-color: #E86C2C !important;
                    color: white !important;
                    border: none !important;
                    border-radius: 4px !important;
                    padding: 5px 10px;
                }

                .close-btn:hover {
                    background-color: #d15a1a !important;
                }

                .modal-description {
                    white-space: pre-wrap;
                    word-wrap: break-word;
                }

                .no-data {
                    text-align: center;
                    color: #666;
                    padding: 20px;
                }

                .search-wrapper {
                    position: relative;
                    margin-bottom: 20px;
                }

                .search-bar {
                    width: 100%;
                    padding: 10px 15px 10px 40px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    font-size: 14px;
                }

                .search-icon {
                    position: absolute;
                    left: 15px;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #666;
                }

                /* Modal Styling */
                .modal {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    z-index: 1050;
                }

                .modal.show {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .modal-dialog {
                    margin: 1.75rem auto;
                    max-width: 500px;
                    width: 100%;
                }

                .modal-content {
                    position: relative;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                .modal-header {
                    padding: 1rem;
                    border-bottom: 1px solid #dee2e6;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                .modal-body {
                    padding: 1rem;
                }

                .modal-footer {
                    padding: 1rem;
                    border-top: 1px solid #dee2e6;
                }

                .modal-backdrop {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    display: none;
                }

                .modal-backdrop.show {
                    display: block;
                    opacity: 0.5;
                }
            </style>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('searchInput');
                    const categoryBtns = document.querySelectorAll('.category-btn');
                    const actionTableBody = document.getElementById('actionTableBody');
                    const actionDetailsModal = document.getElementById('actionDetailsModal');

                    // Function to filter actions based on category and search term
                    function filterActions(category, searchTerm) {
                        const rows = actionTableBody.querySelectorAll('tr');
                        
                        rows.forEach(row => {
                            const actionType = row.children[4].textContent.toLowerCase();
                            const description = row.children[5].textContent.toLowerCase();
                            const searchMatch = description.includes(searchTerm.toLowerCase()) || 
                                             actionType.includes(searchTerm.toLowerCase());
                            const categoryMatch = category === 'all' || actionType === category.toLowerCase();
                            
                            row.style.display = searchMatch && categoryMatch ? '' : 'none';
                        });
                    }

                    // Handle modal content population
                    document.querySelectorAll('.description-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const description = this.getAttribute('data-description');
                            const oldValue = this.getAttribute('data-old-value');
                            const newValue = this.getAttribute('data-new-value');
                            
                            const modalDescription = actionDetailsModal.querySelector('.modal-description');
                            const changesSection = actionDetailsModal.querySelector('.changes-section');
                            const changesContent = actionDetailsModal.querySelector('.changes-content');
                            
                            modalDescription.textContent = description;
                            
                            if (oldValue || newValue) {
                                changesSection.style.display = 'block';
                                let changesText = '';
                                if (oldValue) {
                                    changesText += "From: " + oldValue + "<br>";
                                }
                                if (newValue) {
                                    changesText += "To: " + newValue;
                                }
                                changesContent.innerHTML = changesText;
                            } else {
                                changesSection.style.display = 'none';
                            }
                        });
                    });

                    // Search functionality
                    searchInput.addEventListener('input', function(e) {
                        const searchTerm = e.target.value;
                        const activeCategory = document.querySelector('.category-btn.active').dataset.category;
                        filterActions(activeCategory, searchTerm);
                    });

                    // Category filter functionality
                    categoryBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            // Update active state
                            categoryBtns.forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            
                            // Filter actions
                            const category = this.dataset.category;
                            const searchTerm = searchInput.value;
                            filterActions(category, searchTerm);
                        });
                    });

                    // Initial filter
                    filterActions('all', '');
                });
            </script>
        </body>
        </html>
        <?php
    }
}
        
