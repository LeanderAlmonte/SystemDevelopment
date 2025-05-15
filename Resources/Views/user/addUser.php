<?php
namespace Resources\Views\User;

use Controllers\UserController;

class Adduser {
    public function render($error = null, $firstName = '', $lastName = '') {
require_once __DIR__ . '/../../../lang/lang.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('add_user'); ?> - Eyesightcollectibles</title>
    <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <?php
            // Include dark theme CSS if the selected theme is Dark
            if ($_SESSION['theme'] === 'Dark') {
                echo '<link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/dark.css">';
        }
            ?>
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
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients"><i class="fas fa-user-friends"></i><span><?php echo lang('manage_clients'); ?></span></a></li>
                        <?php if ($role === 'Admin'): ?>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users" class="active"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
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

                    <div class="add-product-container">
                        <div class="inventory-header">
                            <div class="header-content">
                                <h2><i class="fas fa-user-plus"></i> <?php echo lang('add_user'); ?></h2>
                            </div>
            </div>

                <?php if (isset($error) && $error): ?>
                    <div class="error-message" style="color: #b30000; background: #ffeaea; border: 1px solid #ffb3b3; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                        <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=users" class="add-product-form" autocomplete="off">
                    <!-- Dummy fields to prevent browser autofill -->
                    <input type="text" name="fakeusernameremembered" style="display:none">
                    <input type="password" name="fakepasswordremembered" style="display:none">
                    <div class="form-group">
                        <label for="firstName"><?php echo lang('first_name'); ?></label>
                                <input type="text" id="firstName" name="firstName" placeholder="<?php echo lang('first_name'); ?>" value="<?php echo htmlspecialchars($firstName); ?>" required pattern="^[A-Za-z\s\-]+$" oninput="this.setCustomValidity('');" oninvalid="setNameInvalidMessage(this)">
                    </div>

                    <div class="form-group">
                        <label for="lastName"><?php echo lang('last_name'); ?></label>
                                <input type="text" id="lastName" name="lastName" placeholder="<?php echo lang('last_name'); ?>" value="<?php echo htmlspecialchars($lastName); ?>" required pattern="^[A-Za-z\s\-]+$" oninput="this.setCustomValidity('');" oninvalid="setNameInvalidMessage(this)">
                    </div>

                    <div class="form-group">
                        <label for="email"><?php echo lang('email'); ?></label>
                                <input type="email" id="email" name="email" placeholder="<?php echo lang('email'); ?>" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" autocomplete="new-email" oninvalid="this.setCustomValidity('<?php echo lang('please_enter_valid_email'); ?>')" oninput="this.setCustomValidity('')">
                    </div>

                    <div class="form-group">
                        <label for="password"><?php echo lang('password'); ?></label>
                                <input type="password" id="password" name="password" placeholder="<?php echo lang('password'); ?>" required autocomplete="new-password" oninvalid="this.setCustomValidity('<?php echo lang('please_fill_out_this_field'); ?>')" oninput="this.setCustomValidity('')">
                    </div>

                    <div class="form-group">
                        <label for="userType"><?php echo lang('user_type'); ?></label>
                                <select id="userType" name="userType" required oninvalid="this.setCustomValidity('<?php echo lang('please_fill_out_this_field'); ?>')" oninput="this.setCustomValidity('')">
                            <option value="" disabled selected><?php echo lang('select_user_type'); ?></option>
                            <option value="Admin"><?php echo lang('admin'); ?></option>
                            <option value="Employee"><?php echo lang('employee'); ?></option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=users'"><?php echo lang('back'); ?></button>
                        <button type="submit"><?php echo lang('add_user_btn'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    // Localized messages from PHP
    const namePatternError = '<?php echo lang('name_pattern_error'); ?>';
    const pleaseFillOutField = '<?php echo lang('please_fill_out_this_field'); ?>';
    function setNameInvalidMessage(input) {
        if (input.validity.patternMismatch) {
            input.setCustomValidity(namePatternError);
        } else {
            input.setCustomValidity(pleaseFillOutField);
        }
    }
    </script>
</body>
</html> 
        <?php
    }
} 