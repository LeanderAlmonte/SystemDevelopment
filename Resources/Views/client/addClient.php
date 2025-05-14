<?php
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';
require_once __DIR__ . '/../../../Controllers/ClientController.php';
require_once __DIR__ . '/../../../Models/Client.php';
require_once(__DIR__ . '/../../../lang/lang.php');

use controllers\ClientController;

$clientController = new ClientController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $clientController->create($_POST);
    if (isset($result['error'])) {
        $error = $result['error'];
    } else {
        header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=clients');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo lang('add_client'); ?> - Eyesightcollectibles</title>
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
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients" class="active"><i class="fas fa-user-friends"></i><span><?php echo lang('manage_clients'); ?></span></a></li>
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

            <div class="add-product-container">
                <div class="inventory-header">
                    <div class="header-content">
                        <h2><i class="fas fa-user-plus"></i> <?php echo lang('add_client'); ?></h2>
                    </div>
                </div>

                <?php if (isset($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=clients/add" class="add-product-form">
                    <div class="form-group">
                        <label for="clientName"><?php echo lang('client_name'); ?></label>
                        <input type="text" id="clientName" name="clientName" placeholder="<?php echo lang('enter_client_name'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email"><?php echo lang('email'); ?></label>
                        <input type="email" id="email" name="email" placeholder="<?php echo lang('enter_email'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="phone"><?php echo lang('phone'); ?></label>
                        <input type="text" id="phone" name="phone" placeholder="<?php echo lang('enter_phone'); ?>" required>
                    </div>

                    <div class="form-actions">
                        <button type="button" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=clients'"><?php echo lang('back'); ?></button>
                        <button type="submit"><?php echo lang('add_client'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
