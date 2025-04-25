<?php

namespace views\user;

class ManageUsers {
    public function render($data) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Manage Users - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title">Menu Panel</h2>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboard/home"><i class="fas fa-home"></i><span>Home</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboard/manual"><i class="fas fa-book"></i><span>View Manual</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users" class="active"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=product/manageInventory"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=product/soldProducts"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=product/archivedItems"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=history"><i class="fas fa-history"></i><span>History</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=sales"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=auth/logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
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
                            <input type="text" id="searchInput" class="search-bar" placeholder="Search for user by name or email">
                        </div>

                        <!-- User Type Filters -->
                        <div class="category-filters">
                            <button class="category-btn active" data-category="all">All Users</button>
                            <button class="category-btn" data-category="admin">Admins</button>
                            <button class="category-btn" data-category="employee">Employees</button>
                        </div>

                        <!-- Users Table -->
                        <div class="table-container">
                            <table class="inventory-table">
                                <thead>
                                    <tr>
                                        <th>UserID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>User Type</th>
                                        <th>Theme</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody">
                                    <?php if (isset($data['error'])): ?>
                                        <tr><td colspan="6">Error loading users: <?php echo $data['error']; ?></td></tr>
                                    <?php else: ?>
                                        <?php foreach ($data as $user): ?>
                                            <tr>
                                                <td>#<?php echo $user['userID']; ?></td>
                                                <td><?php echo $user['firstName'] . ' ' . $user['lastName']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td><?php echo $user['userType']; ?></td>
                                                <td><?php echo $user['theme']; ?></td>
                                                <td><button class='action-btn'><i class='fas fa-ellipsis-h'></i></button></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="/ecommerce/Project/SystemDevelopment/index.php?url=users/create" class="action-btn">Add User</a>
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
            </script>
        </body>
        </html>
        <?php
    }
}
