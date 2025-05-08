<?php
namespace Resources\Views\Dashboard;

class Manual {
    public function render() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Manual - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>
                .manual-container {
                    background-color: while;
                    padding: 20px;
                    border-radius: 10px;
                    max-height: double;
                    overflow-y: auto;
                    margin-top: 20px;
                }
                .manual-container h2 {
                    color: #e65100;
                    margin-bottom: 10px;
                }
                .manual-section {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    background-color: #FFC38E;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 30px;
                    gap: 20px;
                    flex-wrap: wrap;
                }
                .manual-text {
                    flex: 1;
                    min-width: 250px;
                }
                .manual-section h3 {
                    color: black;
                    margin-bottom: 10px;
                }
                .manual-section ul {
                    padding-left: 20px;
                }
                .manual-section img {
                    max-width: 100%;
                    border: 2px solid #ffa726;
                    border-radius: 5px;
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title">Menu Panel</h2>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span>Home</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual" class="active"><i class="fas fa-book"></i><span>View Manual</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
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

                    <div class="manual-container">
                        <h2>User Manual</h2>
                        <h3>How To Use Our Application</h3>

                        <div class="manual-section">
                            <h3>Steps to Log In</h3>
                            <ul>
                                <li>Enter your Email and Password into the provided fields.</li>
                                <li>Click the login button.</li>
                                <li>If the credentials are correct, you will be redirected to the Admin Home Page.</li>
                                <li>If the credentials are incorrect, an error message will be displayed.</li>
                                <li>To reset your password, click on “Reset Password” and follow the instructions.</li>
                            </ul>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/images/login-example.png" alt="Login screenshot">
                        </div>

                        <div class="manual-section">
                            <h3>Steps to Manage Inventory</h3>
                            <ul>
                                <li>Go to Manage Inventory from the menu.</li>
                                <li>To add a product, click Add Product, enter details, and click Save.</li>
                                <li>To edit a product, click Edit → update the fields → click Update.</li>
                                <li>To delete a product, click Delete and confirm.</li>
                                <li>To view sold products, go to View Sold Products.</li>
                            </ul>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/images/inventory-example.png" alt="Inventory screenshot">
                        </div>

                        <div class="manual-section">
                            <h3>Steps to Manage Inventory</h3>
                            <ul>
                                <li>Go to Manage Inventory from the menu.</li>
                                <li>To add a product, click Add Product, enter details, and click Save.</li>
                                <li>To edit a product, click Edit → update the fields → click Update.</li>
                                <li>To delete a product, click Delete and confirm.</li>
                                <li>To view sold products, go to View Sold Products.</li>
                            </ul>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/images/inventory-example.png" alt="Inventory screenshot">
                        </div>

                        <div class="manual-section">
                            <h3>Steps to Manage Inventory</h3>
                            <ul>
                                <li>Go to Manage Inventory from the menu.</li>
                                <li>To add a product, click Add Product, enter details, and click Save.</li>
                                <li>To edit a product, click Edit → update the fields → click Update.</li>
                                <li>To delete a product, click Delete and confirm.</li>
                                <li>To view sold products, go to View Sold Products.</li>
                            </ul>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/images/inventory-example.png" alt="Inventory screenshot">
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
} 