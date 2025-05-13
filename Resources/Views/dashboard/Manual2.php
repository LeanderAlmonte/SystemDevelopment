<?php
namespace Resources\Views\Dashboard;

class Manual2 {
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
                    overflow-y: auto;
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
                    transform: translateX(-50%) translateX(600px);
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
        <body<?php $theme = $_SESSION['theme'] ?? 'Light'; echo $theme === 'Dark' ? ' class="dark-theme"' : ''; ?>>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title"><?php echo lang('menu_panel'); ?></h2>
                    <?php $role = $_SESSION['userRole'] ?? 'Admin'; ?>
                    <ol class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span><?php echo lang('home'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual/1" class="active"><i class="fas fa-book"></i><span><?php echo lang('view_manual'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                        <?php if ($role === 'Admin'): ?>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys"><i class="fas fa-history"></i><span><?php echo lang('history'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/salesCosts"><i class="fas fa-chart-line"></i><span><?php echo lang('sales_costs'); ?></span></a></li>
                        <?php endif; ?>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=auths/logout"><i class="fas fa-sign-out-alt"></i><span><?php echo lang('logout'); ?></span></a></li>
                    </ol>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <div class="header">
                        <h1 class="brand">Eyesightcollectibles</h1>
                        <div class="welcome-text"><?php echo lang('welcome') . ' ' . explode(' ', $_SESSION['userName'])[0]; ?>! <i class="fas fa-user-circle"></i></div>
                    </div>

                    <div class="manual-header">
                        <div class="manual-header-content" style="flex-direction: row; align-items: center; justify-content: space-between; width: 100%;">
                            <h2 style="margin: 0;"><i class="fas fa-book"></i> User Manual - Continuation</h2>
                            <h3 style="margin: 0; font-size: 15px; font-weight: normal; opacity: 0.85; text-align: right;">How To Use Our Application</h3>
                        </div>
                    </div>

                    <div class="manual-container">
                        <div class="manual-section">
                            <h3>View Sold Products</h3>
                            <ol>
                                <li>Navigate to the menu panel on the left side of the screen.</li>
                                <li>Click on the "Sold Products" option in the menu panel.</li>
                                <li>Use the search bar to find a specific product by name, if needed.</li>
                                <li>Use the filter buttons to narrow down the product categories, if needed.</li>
                                <li>View the list of sold products, which includes columns for ID, Product Name, <br> Category, Total Units Sold, and Sale Price.</li>
                            </ol>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/sp.png" alt="Inventory screenshot">
                        </div>

                        <div class="manual-section">
                            <h3>View Archived Products</h3>
                            <ol>
                                <li>Navigate to the "Archived Items" section from the Menu Panel</li>
                                <li>Use the search bar to find specific archived products by name if needed.</li>
                                <li>Filter products by category using the buttons below the search bar.</li>
                                <li>View the list of archived products, which includes columns for ProductID, <br> Product, Category, Price, Quantity, and Actions.</li>
                                <li>Select products by checking the checkbox next to the ProductID or <br>use the three dots under Actions.</li>
                                <li>Perform actions on the selected products like Unarchive or Delete.</li>
                            </ol>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/a.png" alt="Inventory screenshot">
                        </div>

                        <div class="manual-section">
                            <h3>View Action History</h3>
                            <ol>
                                <li>Navigate to the menu panel on the left side of the screen.</li>
                                <li>Click on the "History" option to access the Action History page.</li>
                                <li>Use the search bar to find specific actions by user ID, <br>product ID, or action type.</li>
                                <li>Filter actions using the buttons <br>(e.g., Add, Update, Delete, Archive, Unarchive, Sale).</li>
                                <li>View the list of recorded actions, including timestamps, user IDs, product IDs, <br>quantities, action types, and descriptions.</li>
                                <li>Click on View button under Description to view more details if needed.</li>
                            </ol>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/h.png" alt="Inventory screenshot">
                        </div>

                        <div class="manual-section">
                            <h3>View Sales & Costs</h3>
                            <ol>
                                <li>Navigate to the menu panel on the left side of the screen.</li>
                                <li>Click on the "Sales/Costs" option to access the Sales and Costs page.</li>
                                <li>Hover over the pie chart on different colors to get a quick view <br>of the ammount of Reevenu, Sales and Costs.</li>
                                <li>The legend shows what each color indicates, green for Revenu, red for <br>Cost and blue for Profit/Loss</li>
                                <li>Analyze the profit margin by comparing revenue and costs for each product.</li>
                                <li>Export the sales report if needed using the "Download Report" button.</li>
                            </ol>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/sc.png" alt="Inventory screenshot">
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="pagination">
                        <a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual/1">&lt;</a>
                        <a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual/1">1</a>
                        <a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual/2" class="active">2</a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}