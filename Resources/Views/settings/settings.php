<?php
namespace Resources\Views\Settings;

class Settings {
    public function render($userData = null) {
        require_once __DIR__ . '/../../../lang/lang.php';
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo lang('settings'); ?> - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

                    <div class="settings-container">
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="success-message">
                                <?php 
                                    echo $_SESSION['success'];
                                    unset($_SESSION['success']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <!-- Account Settings -->
                        <h2><?php echo lang('account_setting'); ?></h2>
                        <div class="settings-option">
                            <span><?php echo lang('change_password'); ?></span>
                            <button class="settings-btn" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=settings/changePassword'"><?php echo lang('change'); ?></button>
                        </div>
                        <div class="settings-option">
                            <span>Two-Factor Authentication</span>
                            <?php if ($_SESSION['twoFactorEnabled']): ?>
                                <button class="settings-btn" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=settings/disable2fa'">Disable 2FA</button>
                            <?php else: ?>
                                <button class="settings-btn" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=settings/enable2fa'">Enable 2FA</button>
                            <?php endif; ?>
                        </div>

                        <!-- Preferences -->
                        <h2><?php echo lang('preferences'); ?></h2>
                        <div class="settings-option">
                            <span><?php echo lang('language_selection'); ?></span>
                            <form method="POST" action="">
                                <select name="lang" class="settings-btn" onchange="this.form.submit()">
                                    <option value="en" <?php if(($_SESSION['lang'] ?? 'en') === 'en') echo 'selected'; ?>>English</option>
                                    <option value="fr_CA" <?php if(($_SESSION['lang'] ?? 'en') === 'fr_CA') echo 'selected'; ?>>Français (Canada)</option>
                                </select>
                            </form>
                        </div>
                        <div class="settings-option">
                            <span><?php echo lang('notification_settings'); ?></span>
                            <button class="settings-btn">Configure</button>
                        </div>
                        <div class="settings-option">
                            <span><?php echo lang('theme'); ?></span>
                            <button class="settings-btn"><?php echo lang('switch_theme'); ?></button>
                        </div>

                        <!-- Support -->
                        <h2><?php echo lang('support'); ?></h2>
                        <div class="settings-option">
                            <span><?php echo lang('contact_support'); ?></span>
                            <button class="settings-btn"><?php echo lang('contact'); ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .success-message {
                    color: #155724;
                    margin-bottom: 15px;
                    padding: 10px;
                    background-color: #d4edda;
                    border: 1px solid #c3e6cb;
                    border-radius: 4px;
                }
            </style>
        </body>
        </html>
        <?php
    }
}
