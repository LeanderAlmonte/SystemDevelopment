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
                    padding: 10px;
                    margin-top: 40px;
                    margin-bottom: 20px;
                    text-align: center;
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
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span><?php echo lang('home'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual" class="active"><i class="fas fa-book"></i><span><?php echo lang('view_manual'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients"><i class="fas fa-user-friends"></i><span><?php echo lang('manage_clients'); ?></span></a></li>
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
                        <div class="welcome-text"><?php echo lang('welcome') . ' ' . explode(' ', $_SESSION['userName'])[0]; ?>! <i class="fas fa-user-circle"></i></div>
                    </div>

                    <div class="manual-header">
                        <div class="manual-header-content" style="flex-direction: row; align-items: center; justify-content: space-between; width: 100%;">
                            <h2 style="margin: 0;"><i class="fas fa-book"></i> <?php echo lang('user_manual'); ?></h2>
                            <h3 style="margin: 0; font-size: 15px; font-weight: normal; opacity: 0.85; text-align: right;"><?php echo lang('how_to_use_app'); ?></h3>
                        </div>
                    </div>

                    <div class="manual-container">
                        <div class="manual-section">
                            <h3><?php echo lang('steps_to_login'); ?></h3>
                            <ol>
                                <li><?php echo lang('manual_login_step1'); ?></li>
                                <li><?php echo lang('manual_login_step2'); ?></li>
                                <li><?php echo lang('manual_login_step3'); ?></li>
                                <li><?php echo lang('manual_login_step4'); ?></li>
                                <li><?php echo lang('manual_login_step5'); ?></li>
                            </ol>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/m6.png" alt="Login screenshot">
                        </div>

                        <div class="manual-section">
                            <h3><?php echo lang('home_page'); ?></h3>
                            <ol>
                                <li><?php echo lang('manual_home_step1'); ?></li>
                                <li><?php echo lang('manual_home_step2'); ?></li>
                                <li><?php echo lang('manual_home_step3'); ?></li>
                                <li><?php echo lang('manual_home_step4'); ?></li>
                                <li><?php echo lang('manual_home_step5'); ?></li>
                                <li><?php echo lang('manual_home_step6'); ?></li>
                                <li><?php echo lang('manual_home_step7'); ?></li>
                            </ol>

                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/home.png" alt="Inventory screenshot">
                        </div>

                        <div class="manual-section">
                            <h3><?php echo lang('steps_to_manage_users'); ?></h3>
                            <ol>
                            <li><?php echo lang('manual_users_step1'); ?></li>
                            <li><?php echo lang('manual_users_step2'); ?></li>
                            <li><?php echo lang('manual_users_step3'); ?></li>
                            <li><?php echo lang('manual_users_step4'); ?></li>
                            <li><?php echo lang('manual_users_step5'); ?></li>
                            </ol>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/u2.png" alt="Inventory screenshot">
                        </div>

                        <div class="manual-section">
                            <h3><?php echo lang('steps_to_manage_inventory'); ?></h3>
                            <ol>
                            <li><?php echo lang('manual_inventory_step1'); ?></li>
                            <li><?php echo lang('manual_inventory_step2'); ?></li>
                            <li><?php echo lang('manual_inventory_step3'); ?></li>
                            <li><?php echo lang('manual_inventory_step4'); ?></li>
                            <li><?php echo lang('manual_inventory_step5'); ?></li>
                            <li><?php echo lang('manual_inventory_step6'); ?></li>
                            </ol>
                            <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/mp.png" alt="Inventory screenshot">
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagination">
                <a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual/1" class="active">1</a>
                <a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual/2">2</a>
                <a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual/2">&gt;</a>
            </div>
        </body>
        </html>
        <?php
    }
} 