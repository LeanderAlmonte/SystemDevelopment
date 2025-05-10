<?php
namespace Resources\Views\Dashboard;

class Manual1 {
    public function render() {
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo lang('view_manual'); ?> - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>
                .manual-container {
                    background-color: white;
                    padding: 20px;
                    border-radius: 10px;
                    margin-top: 20px;
                    text-align: center;
                }
                .manual-container h2 {
                    color: black;
                    margin-bottom: 20px;
                    justify-content: center;
                }

                .manual-container h3 {
                    margin-bottom: 20px;
                }
                .manual-section {
                    display: flex;
                    justify-content: space-between;
                    background-color: #FFC38E;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 30px;
                    gap: 20px;
                    flex-wrap: wrap;
                    min-height: 250px;
                    text-align: left;
                }
                
                .manual-section h3 {
                    color: black;
                    margin-bottom: 10px;
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-start;
                }
                .manual-section ol {
                    padding-left: 20px;
                    margin: 0;
                    font-family: Arial, sans-serif;
                    font-size: 16px;
                    color: #333;
                    line-height: 1.6;
                }
                .manual-section ol li {
                    margin-bottom: 10px;
                }
                .manual-section img {
                    width: 350px;
                    height: auto;
                    border: 2px solid #ffa726;
                    border-radius: 5px;
                    margin-top: 10px;
                }
                .pagination {
                    display: flex;
                    justify-content: center;
                    gap: 10px;
                    width: 50px;
                    background: #f4f4f4;
                    padding: 10px;
                    margin-top: 40px;
                    margin-bottom: 20px;
                    text-align: center;
                    transform: translateX(-50%) translateX(850px);
                }

                .pagination a {
                    text-decoration: none;
                    padding: 8px 12px;
                    background-color: #FFC38E;
                    color: black;
                    border-radius: 5px;
                    margin: 0 5px;
                }
                .pagination a.active {
                    font-weight: bold;
                    background-color: #ffa726;
                }


            </style>
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title"><?php echo lang('menu_panel'); ?></h2>
                    <ol class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span><?php echo lang('home'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual" class="active"><i class="fas fa-book"></i><span><?php echo lang('view_manual'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys"><i class="fas fa-history"></i><span><?php echo lang('history'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/salesCosts"><i class="fas fa-chart-line"></i><span><?php echo lang('sales_costs'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=auths/logout"><i class="fas fa-sign-out-alt"></i><span><?php echo lang('logout'); ?></span></a></li>
                    </ol>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <div class="header">
                        <h1 class="brand">Eyesightcollectibles</h1>
                        <div class="welcome-text"><?php echo lang('welcome') . ' ' . explode(' ', $_SESSION['userName'])[0]; ?>! <i class="fas fa-user-circle"></i></div>
                    </div>

                    <div class="manual-container">
                        <h2>User Manual</h2>
                        <h3>How To Use Our Application</h3>

                        <div class="manual-section">
                            <h3>Steps to Log In</h3>
                            <ol>
                                <li>Enter your Email and Password into the provided fields.</li>
                                <li>Click the login button.</li>
                                <li>If the credentials are correct, you will be redirected to the Admin Home Page.</li>
                                <li>If the credentials are incorrect, an error message will be displayed.</li>
                                <li>To reset your password, click on "Reset Password" and follow the instructions.</li>
                            </ol>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/m6.png" alt="Login screenshot">
                        </div>

                        <div class="manual-section">
                            <h3>Home Page</h3>
                            <ol>
                                <li>View the Top 5 Best Sellers section to see the most popular products</li>
                                <li>Check the Top 5 Most Stocked section for items with the highest inventory</li>
                                <li>Explore the Random Pokémon section to see a featured Pokémon with its details</li>
                                <li>Use the left-side menu to navigate different sections like Inventory, History, and Sales</li>
                                <li>Click on a product to view more details or manage inventory actions</li>
                                <li>Check the displayed Pokémon height and weight for reference</li>
                                <li>Click the "Get Another Pokémon" button to generate a new random Pokémon</li>
                            </ol>

                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/home.png" alt="Inventory screenshot">
                        </div>

                        <div class="manual-section">
                            <h3>Steps to Manage Users</h3>
                            <ol>
                            <li>Navigate the menu panel to access Manage User</li>
                            <li>Use the search bar to find a user by name</li>
                            <li>Click on the 3 buttons on top to filter the user by role</li>
                            <li>Use the Actions button to edit or delete user</li>
                            <li>Click the Add User button to add a new user</li>
                            </ol>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/u2.png" alt="Inventory screenshot">
                        </div>

                        <div class="manual-section">
                            <h3>Steps to Manage Inventory</h3>
                            <ol>
                            <li>Navigate the menu panel to access Manage Inventory</li>
                            <li>Use the search bar to find a product by name</li>
                            <li>Click on a category to filter products</li>
                            <li>Use the Actions button to edit archive, delete or edit products</li>
                            <li>Click Process Order to process selected products</li>
                            <li>Click Add Product to add a new item to the inventory</li>
                            </ol>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/mp.png" alt="Inventory screenshot">
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagination">
                <a href="#" class="active">1</a>
                <a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual&page=2">2</a>
                <a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual&page=2">&gt;</a>
            </div>
        </body>
        </html>
        <?php
    }
} 