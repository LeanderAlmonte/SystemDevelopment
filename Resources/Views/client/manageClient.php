<?php

namespace views\client;

class ManageClients {
    public function render($data) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Manage Clients - Eyesightcollectibles</title>
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
                    <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients" class="active"><i class="fas fa-user-friends"></i><span>Manage Clients</span></a></li>
                    <!-- Add other links as needed -->
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
                        <input type="text" id="searchInput" class="search-bar" placeholder="Search for client by name or email">
                    </div>

                    <!-- Clients Table -->
                    <div class="table-container">
                        <table class="inventory-table">
                            <thead>
                            <tr>
                                <th>ClientID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="clientTableBody">
                            <?php if (isset($data['error'])): ?>
                                <tr><td colspan="5">Error loading clients: <?php echo $data['error']; ?></td></tr>
                            <?php else: ?>
                                <?php foreach ($data as $client): ?>
                                    <tr>
                                        <td>#<?php echo $client['clientID']; ?></td>
                                        <td><?php echo $client['firstName'] . ' ' . $client['lastName']; ?></td>
                                        <td><?php echo $client['email']; ?></td>
                                        <td><?php echo $client['phone']; ?></td>
                                        <td class="actions-cell">
                                            <div class="dropdown">
                                                <button class="action-btn" onclick="toggleDropdown(this, <?php echo $client['clientID']; ?>)">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div id="dropdown-<?php echo $client['clientID']; ?>" class="dropdown-content">
                                                    <a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients/update&id=<?php echo $client['clientID']; ?>" class="dropdown-item">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=clients/delete" style="display: inline;" onsubmit="return confirmDelete('<?php echo htmlspecialchars($client['firstName'] . ' ' . $client['lastName']); ?>')">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="clientId" value="<?php echo $client['clientID']; ?>">
                                                        <button type="submit" class="dropdown-item delete">
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
                        <a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients/create" class="action-btn">Add Client</a>
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
