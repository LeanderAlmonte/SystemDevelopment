<?php
namespace Resources\Views\Settings;

require_once(__DIR__ . '/../../../lang/lang.php');

class Disable2FA {
    public function render($error = null) {
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo lang('disable_2fa'); ?> - Eyesightcollectibles</title>
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
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings" class="active"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
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

                    <div class="settings-container">
                        <div class="inventory-header">
                            <div class="header-content" style="flex-direction: row; align-items: center; justify-content: space-between; width: 100%;">
                                <h2 style="margin: 0;"><i class="fas fa-shield-alt"></i> <?php echo lang('disable_2fa'); ?></h2>
                                <span style="margin: 0; font-size: 15px; font-weight: normal; opacity: 0.85; text-align: right;"><?php echo lang('disable_2fa_description'); ?></span>
                            </div>
                        </div>

                        <?php if ($error): ?>
                            <div class="error-message">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <div class="settings-option">
                            <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=settings/disable2fa" class="settings-form">
                                <div class="form-group">
                                    <label for="code"><?php echo lang('verification_code'); ?></label>
                                    <input type="text" id="code" name="code" placeholder="<?php echo lang('enter_verification_code'); ?>" required>
                                </div>
                                <div class="form-actions">
                                    <button type="button" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=settings'" class="settings-btn"><?php echo lang('back'); ?></button>
                                    <button type="submit" class="settings-btn primary"><?php echo lang('disable_2fa'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        <style>
            .settings-form {
                max-width: 500px;
                margin: 20px auto;
            }
            .form-group {
                margin-bottom: 20px;
            }
            .form-group label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
            }
            .form-group input {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                font-size: 16px;
            }
            .form-actions {
                display: flex;
                gap: 10px;
                justify-content: flex-end;
            }
            .settings-btn {
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                transition: all 0.3s ease;
            }
            .settings-btn:not(.primary) {
                background-color: #f8f9fa;
                color: #333;
                border: 1px solid #ddd;
            }
            .settings-btn.primary {
                background-color: #ff6b00;
                color: white;
            }
            .settings-btn:hover {
                opacity: 0.9;
                transform: translateY(-1px);
            }
            .error-message {
                color: #dc3545;
                background-color: #f8d7da;
                border: 1px solid #f5c6cb;
                padding: 10px;
                border-radius: 4px;
                margin-bottom: 20px;
            }
            .dark-theme .settings-btn:not(.primary) {
                background-color: #2d2d2d;
                color: #fff;
                border-color: #444;
            }
            .dark-theme .form-group input {
                background-color: #2d2d2d;
                color: #fff;
                border-color: #444;
            }
            .dark-theme .form-group input::placeholder {
                color: #888;
            }
        </style>
        </html>
        <?php
    }
} 