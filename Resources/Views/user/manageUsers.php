<?php

namespace views\user;

require_once(__DIR__ . '/../../../lang/lang.php');

class ManageUsers {
    public function render($data) {
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo lang('manage_users'); ?> - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body<?php $theme = $_SESSION['theme'] ?? 'Light'; echo $theme === 'Dark' ? ' class="dark-theme"' : ''; ?>>
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
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users" class="active"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys"><i class="fas fa-history"></i><span><?php echo lang('history'); ?></span></a></li>
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
                            <div class="header-content" style="flex-direction: row; align-items: center; justify-content: space-between; width: 100%;">
                                <h2 style="margin: 0;"><i class="fas fa-users"></i> <?php echo lang('manage_users'); ?></h2>
                                <span style="margin: 0; font-size: 15px; font-weight: normal; opacity: 0.85; text-align: right;">Manage users and their roles</span>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="searchInput" class="search-bar" placeholder="<?php echo lang('search_user_placeholder'); ?>">
                        </div>

                        <!-- User Type Filters -->
                        <div class="category-filters">
                            <button class="category-btn active" data-category="all"><?php echo lang('all_users'); ?></button>
                            <button class="category-btn" data-category="admin"><?php echo lang('admins'); ?></button>
                            <button class="category-btn" data-category="employee"><?php echo lang('employees'); ?></button>
                        </div>

                        <!-- Users Table -->
                        <div class="table-container">
                            <table class="inventory-table">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('userid'); ?></th>
                                        <th><?php echo lang('name'); ?></th>
                                        <th><?php echo lang('email'); ?></th>
                                        <th><?php echo lang('user_type'); ?></th>
                                        <th><?php echo lang('theme'); ?></th>
                                        <th><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody">
                                    <?php if (isset($data['error'])): ?>
                                        <tr><td colspan="6"><?php echo lang('error_loading_users'); ?>: <?php echo $data['error']; ?></td></tr>
                                    <?php else: ?>
                                        <?php foreach ($data as $user): ?>
                                            <tr>
                                                <td>#<?php echo $user['userID']; ?></td>
                                                <td><?php echo $user['firstName'] . ' ' . $user['lastName']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td><?php echo lang(strtolower($user['userType'])); ?></td>
                                                <td><?php echo lang(strtolower($user['theme'])); ?></td>
                                                <td class="actions-cell">
                                                    <div class="dropdown">
                                                        <button class="action-btn" onclick="toggleDropdown(this, <?php echo $user['userID']; ?>)">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </button>
                                                        <div id="dropdown-<?php echo $user['userID']; ?>" class="dropdown-content">
                                                            <a href="/ecommerce/Project/SystemDevelopment/index.php?url=users/update&id=<?php echo $user['userID']; ?>" class="dropdown-item">
                                                                <i class="fas fa-edit"></i> <?php echo lang('edit'); ?>
                                                            </a>
                                                            <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=users/delete" style="display: inline;" onsubmit="return confirmDelete('<?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?>')">
                                                                <input type="hidden" name="action" value="delete">
                                                                <input type="hidden" name="userId" value="<?php echo $user['userID']; ?>">
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

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="/ecommerce/Project/SystemDevelopment/index.php?url=users/create" class="action-btn"><?php echo lang('add_user'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('searchInput');
                    const categoryBtns = document.querySelectorAll('.category-btn');
                    const userTableBody = document.getElementById('userTableBody');

                    // Function to filter users based on type and search term
                    function filterUsers(type, searchTerm) {
                        const rows = userTableBody.querySelectorAll('tr');
                        
                        rows.forEach(row => {
                            const userName = row.children[1].textContent.toLowerCase();
                            const userEmail = row.children[2].textContent.toLowerCase();
                            const userType = row.children[3].textContent.toLowerCase();
                            const searchMatch = userName.includes(searchTerm.toLowerCase()) || 
                                              userEmail.includes(searchTerm.toLowerCase());
                            const typeMatch = type === 'all' || userType.includes(type);
                            
                            row.style.display = searchMatch && typeMatch ? '' : 'none';
                        });
                    }

                    // Search functionality
                    searchInput.addEventListener('input', function(e) {
                        const searchTerm = e.target.value;
                        const activeType = document.querySelector('.category-btn.active').dataset.category;
                        filterUsers(activeType, searchTerm);
                    });

                    // Type filter functionality
                    categoryBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            // Update active state
                            categoryBtns.forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            
                            // Filter users
                            const type = this.dataset.category;
                            const searchTerm = searchInput.value;
                            filterUsers(type, searchTerm);
                        });
                    });

                    // Initial filter
                    filterUsers('all', '');
                });

                function confirmDelete(userName) {
                    return confirm('<?php echo lang('confirm_delete'); ?>'.replace('{user}', userName));
                }

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

                function toggleDropdown(button, userId) {
                    const dropdowns = document.querySelectorAll('.dropdown-content');
                    dropdowns.forEach(dropdown => {
                        if (dropdown.id !== `dropdown-${userId}`) {
                            dropdown.classList.remove('show');
                        }
                    });
                    
                    const dropdown = document.getElementById(`dropdown-${userId}`);
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
