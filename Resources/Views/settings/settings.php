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
        <body<?php 
            $theme = $_SESSION['theme'] ?? ($userData['theme'] ?? 'Light');
            echo $theme === 'Dark' ? ' class="dark-theme"' : '';
        ?>>
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
                                <h2 style="margin: 0;"><i class="fas fa-cog"></i> <?php echo lang('settings'); ?></h2>
                                <span style="margin: 0; font-size: 15px; font-weight: normal; opacity: 0.85; text-align: right;">Manage your account and preferences</span>
                            </div>
                        </div>
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
                                <button class="settings-btn" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=settings/disable2fa'"><?php echo lang('disable_2fa'); ?></button>
                            <?php else: ?>
                                <button class="settings-btn" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=settings/enable2fa'"><?php echo lang('enable_2fa'); ?></button>
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
                            <span><?php echo lang('theme'); ?></span>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="theme" value="<?php echo ($_SESSION['theme'] ?? ($userData['theme'] ?? 'Light')) === 'Dark' ? 'Light' : 'Dark'; ?>">
                                <button class="settings-btn" type="submit">
                                    <?php
                                        $isDark = ($_SESSION['theme'] ?? ($userData['theme'] ?? 'Light')) === 'Dark';
                                        echo $isDark ? 'Enable Light Mode' : 'Enable Dark Mode';
                                    ?>
                                </button>
                            </form>
                        </div>

                        <!-- Support -->
                        <h2><?php echo lang('support'); ?></h2>
                        <div class="settings-option">
                            <span><?php echo lang('contact_support'); ?></span>
                            <button class="settings-btn" onclick="showContactModal()"><?php echo lang('contact'); ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Support Modal -->
            <div id="contactModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><i class="fas fa-envelope"></i> <?php echo lang('contact_support'); ?></h3>
                        <span class="close" onclick="closeContactModal()">&times;</span>
                    </div>
                    <div class="modal-body">
                        <p><?php echo lang('support_email_message'); ?></p>
                        <div class="support-email">
                            <a href="mailto:support@eyesightcollectibles.com">support@eyesightcollectibles.com</a>
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

                /* Modal Styles */
                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1000;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0,0,0,0.5);
                }

                .modal-content {
                    background-color: #fefefe;
                    margin: 15% auto;
                    padding: 20px;
                    border-radius: 8px;
                    width: 80%;
                    max-width: 500px;
                    position: relative;
                    animation: modalSlideIn 0.3s ease-out;
                }

                .dark-theme .modal-content {
                    background-color: #2d2d2d;
                    color: #fff;
                }

                .modal-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                    padding-bottom: 10px;
                    border-bottom: 1px solid #ddd;
                }

                .dark-theme .modal-header {
                    border-bottom-color: #444;
                }

                .modal-header h3 {
                    margin: 0;
                    color: #ff6b00;
                }

                .close {
                    color: #aaa;
                    font-size: 28px;
                    font-weight: bold;
                    cursor: pointer;
                }

                .close:hover {
                    color: #ff6b00;
                }

                .modal-body {
                    padding: 10px 0;
                }

                .support-email {
                    margin-top: 20px;
                    text-align: center;
                }

                .support-email a {
                    color: #ff6b00;
                    text-decoration: none;
                    font-size: 18px;
                    font-weight: 500;
                }

                .support-email a:hover {
                    text-decoration: underline;
                }

                @keyframes modalSlideIn {
                    from {
                        transform: translateY(-100px);
                        opacity: 0;
                    }
                    to {
                        transform: translateY(0);
                        opacity: 1;
                    }
                }
            </style>

            <script>
                function showContactModal() {
                    document.getElementById('contactModal').style.display = 'block';
                }

                function closeContactModal() {
                    document.getElementById('contactModal').style.display = 'none';
                }

                // Close modal when clicking outside
                window.onclick = function(event) {
                    var modal = document.getElementById('contactModal');
                    if (event.target == modal) {
                        modal.style.display = 'none';
                    }
                }
            </script>
        </body>
        </html>
        <?php
    }
}
