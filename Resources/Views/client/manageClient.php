<?php

namespace views\client;

require_once(__DIR__ . '/../../../lang/lang.php');

class ManageClients {
    public function render($data) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo lang('manage_clients'); ?> - Eyesightcollectibles</title>
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
                    <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients" class="active"><i class="fas fa-user-friends"></i><span><?php echo lang('manage_clients'); ?></span></a></li>
                    <?php if ($role === 'Admin'): ?>
                    <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
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
                    <div class="welcome-text">Welcome <?php echo explode(' ', $_SESSION['userName'])[0]; ?>! <i class="fas fa-user-circle"></i></div>
                </div>

                <div class="inventory-container">
                    <div class="inventory-header">
                        <div class="header-content" style="flex-direction: row; align-items: center; justify-content: space-between; width: 100%;">
                            <h2 style="margin: 0;"><i class="fas fa-user-friends"></i> <?php echo lang('manage_clients'); ?></h2>
                            <span style="margin: 0; font-size: 15px; font-weight: normal; opacity: 0.85; text-align: right;">Manage your clients</span>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="searchInput" class="search-bar" placeholder="<?php echo lang('search_client'); ?>">
                    </div>

                    <!-- Clients Table -->
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                            <tr>
                                <th><?php echo lang('clientid'); ?></th>
                                <th><?php echo lang('client_name'); ?></th>
                                <th><?php echo lang('email'); ?></th>
                                <th><?php echo lang('phone_number'); ?></th>
                                <th><?php echo lang('actions'); ?></th>
                            </tr>
                            </thead>
                            <tbody id="clientTableBody">
                            <?php if (isset($data['error'])): ?>
                                <tr><td colspan="5"><?php echo lang('error_loading_clients'); ?>: <?php echo $data['error']; ?></td></tr>
                            <?php else: ?>
                                <?php foreach ($data as $client): ?>
                                    <tr>
                                        <td>#<?php echo $client['clientID']; ?></td>
                                        <td><?php echo htmlspecialchars($client['clientName']); ?></td>
                                        <td><?php echo htmlspecialchars($client['email']); ?></td>
                                        <td><?php echo htmlspecialchars($client['phoneNumber']); ?></td>
                                        <td class="actions-cell">
                                            <div class="dropdown">
                                                <button class="action-btn" onclick="toggleDropdown(this, <?php echo $client['clientID']; ?>)">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div id="dropdown-<?php echo $client['clientID']; ?>" class="dropdown-content">
                                                    <a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients/update&id=<?php echo $client['clientID']; ?>" class="dropdown-item">
                                                        <i class="fas fa-edit"></i> <?php echo lang('edit'); ?>
                                                    </a>
                                                    <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=clients/delete" style="display: inline;" onsubmit="return confirmDelete('<?php echo htmlspecialchars($client['clientName']); ?>')">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="clientId" value="<?php echo $client['clientID']; ?>">
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
                        <a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients/create" class="action-btn"><?php echo lang('add_client'); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const clientTableBody = document.getElementById('clientTableBody');

                // Filter clients
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = clientTableBody.querySelectorAll('tr');
                    
                    rows.forEach(row => {
                        const name = row.children[1].textContent.toLowerCase();
                        const email = row.children[2].textContent.toLowerCase();
                        row.style.display = name.includes(searchTerm) || email.includes(searchTerm) ? '' : 'none';
                    });
                });
            });

            function confirmDelete(clientName) {
                return confirm('Are you sure you want to delete "' + clientName + '"? This action cannot be undone.');
            }

            function toggleDropdown(button, clientId) {
                const dropdowns = document.querySelectorAll('.dropdown-content');
                dropdowns.forEach(dropdown => {
                    if (dropdown.id !== `dropdown-${clientId}`) {
                        dropdown.classList.remove('show');
                    }
                });
                const dropdown = document.getElementById(`dropdown-${clientId}`);
                dropdown.classList.toggle('show');
            }

            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-content').forEach(el => el.classList.remove('show'));
                }
            });
        </script>
        </body>
        </html>
        <?php
    }
}
