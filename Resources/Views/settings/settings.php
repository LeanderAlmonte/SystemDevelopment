<?php
namespace Resources\Views\Settings;

// If the theme switch button is clicked, toggle the theme
if (isset($_POST['switch_theme'])) {
    // Toggle between 'light' and 'dark'
    $_SESSION['theme'] = ($_SESSION['theme'] ?? 'light') === 'light' ? 'dark' : 'light';
    setcookie('theme', $_SESSION['theme'], time() + (86400 * 30), "/"); // Store theme in a cookie for 30 days
    header("Location: " . $_SERVER['PHP_SELF']); // Reload the page to apply the new theme
    exit(); // Stop further script execution
}

// Check if the theme is stored in a cookie, otherwise use session
if (isset($_COOKIE['theme'])) {
    $_SESSION['theme'] = $_COOKIE['theme'];
} elseif (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light'; // Default to light theme if no theme is set
}

class Settings {
    public function render() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Settings - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <?php
    // Include dark theme CSS if the selected theme is dark
    if ($_SESSION['theme'] === 'dark') {
        echo '<link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/dark.css">';
    }
    ?>
            <style>
            
            .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0; top: 0;
                width: 100%; height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
            }
            .modal-content {
                background-color: #fff;
                margin: 10% auto;
                padding: 20px;
                width: 300px;
                border-radius: 8px;
                box-shadow: 0 0 10px #000;
            }
            .close {
                float: right;
                font-size: 20px;
                cursor: pointer;
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

                    <div class="settings-container">
                        <!-- Account Settings -->
                        <h2><?php echo lang('account_setting'); ?></h2>
                        <div class="settings-option">
                            <span><?php echo lang('change_password'); ?></span>
                            <button class="settings-btn" onclick="location.href='resetPassword.php';"><?php echo lang('change'); ?></button>
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
                            <button class="settings-btn" onclick="openModal()">Configure</button>
                        </div>
                        <div class="settings-option">
                            <span><?php echo lang('theme'); ?></span>
                            <button type="submit" name="switch_theme" class="settings-btn"><?php echo lang('switch_theme'); ?></button>
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
            <!-- Notification Settings Modal -->
            <div id="notificationModal" class="modal">
            <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2><?php echo lang('notification_settings'); ?></h2>
            <form method="post" action="">
            <label><input type="checkbox" name="email_notifications"> Email Notifications</label><br>
            <label><input type="checkbox" name="sms_alerts"> SMS Alerts</label><br>
            <label><input type="checkbox" name="push_notifications"> Push Notifications</label><br><br>
            <button type="submit">Save</button>
            </form>
        </div>
        </div>
    <script>
    function openModal() {
        document.getElementById("notificationModal").style.display = "block";
    }
    function closeModal() {
        document.getElementById("notificationModal").style.display = "none";
    }
    window.onclick = function(event) {
        let modal = document.getElementById("notificationModal");
        if (event.target == modal) {
            modal.style.display = "none";
    }
}
    </script>
        </body>
        </html>
        <?php
    }
}
?>