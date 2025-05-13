<?php
namespace Resources\Views\Settings;

class ChangePassword {
    public function render($error = null) {
        require_once __DIR__ . '/../../../lang/lang.php';
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo lang('change_password'); ?> - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>
                .change-password-container {
                    max-width: 500px;
                    margin: 20px auto;
                    padding: 20px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }

                .form-group {
                    margin-bottom: 20px;
                }

                .form-group label {
                    display: block;
                    margin-bottom: 5px;
                    font-weight: normal;
                }

                .form-group input {
                    width: 100%;
                    padding: 8px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                }

                .form-actions {
                    display: flex;
                    gap: 10px;
                    margin-top: 20px;
                }

                .form-actions button {
                    padding: 8px 20px;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    background-color: #fff;
                    cursor: pointer;
                }

                .form-actions button[type="submit"] {
                    background-color: var(--brown-color);
                    color: white;
                    border: none;
                }

                .form-actions button[type="submit"]:hover {
                    background-color: #654321;
                }

                .error-message {
                    color: #dc3545;
                    margin-bottom: 15px;
                    padding: 10px;
                    background-color: #f8d7da;
                    border: 1px solid #f5c6cb;
                    border-radius: 4px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title"><?php echo lang('menu_panel'); ?></h2>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span><?php echo lang('home'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span><?php echo lang('view_manual'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings" class="active"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
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

                    <div class="change-password-container">
                        <h2><?php echo lang('change_password'); ?></h2>
                        
                        <?php if (isset($error)): ?>
                            <div class="error-message"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=settings/changePassword">
                            <div class="form-group">
                                <label for="currentPassword"><?php echo lang('current_password'); ?></label>
                                <input type="password" id="currentPassword" name="currentPassword" required>
                            </div>

                            <div class="form-group">
                                <label for="newPassword"><?php echo lang('new_password'); ?></label>
                                <input type="password" id="newPassword" name="newPassword" required>
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword"><?php echo lang('confirm_password'); ?></label>
                                <input type="password" id="confirmPassword" name="confirmPassword" required>
                            </div>

                            <div class="form-actions">
                                <button type="button" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=settings'"><?php echo lang('back'); ?></button>
                                <button type="submit"><?php echo lang('change_password'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
} 