<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Eyesightcollectibles' : 'Eyesightcollectibles'; ?></title>
    <base href="/ecommerce/Project/SystemDevelopment/">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Menu Panel -->
        <div class="menu-panel">
            <h2 class="menu-title">Menu Panel</h2>
            <ul class="menu-items">
                <li><a href="Resources/Views/dashboard/home.php" class="<?php echo isset($activePage) && $activePage === 'home' ? 'active' : ''; ?>"><i class="fas fa-home"></i><span>Home</span></a></li>
                <li><a href="Resources/Views/dashboard/manual.php" class="<?php echo isset($activePage) && $activePage === 'manual' ? 'active' : ''; ?>"><i class="fas fa-book"></i><span>View Manual</span></a></li>
                <li><a href="Resources/Views/settings/settings.php" class="<?php echo isset($activePage) && $activePage === 'settings' ? 'active' : ''; ?>"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                <li><a href="Resources/Views/users/users.php" class="<?php echo isset($activePage) && $activePage === 'users' ? 'active' : ''; ?>"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                <li><a href="Resources/Views/product/manageInventory.php" class="<?php echo isset($activePage) && $activePage === 'inventory' ? 'active' : ''; ?>"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                <li><a href="Resources/Views/product/soldProducts.php" class="<?php echo isset($activePage) && $activePage === 'sold' ? 'active' : ''; ?>"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
                <li><a href="Resources/Views/product/archivedItems.php" class="<?php echo isset($activePage) && $activePage === 'archived' ? 'active' : ''; ?>"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                <li><a href="Resources/Views/history/history.php" class="<?php echo isset($activePage) && $activePage === 'history' ? 'active' : ''; ?>"><i class="fas fa-history"></i><span>History</span></a></li>
                <li><a href="Resources/Views/sales/sales.php" class="<?php echo isset($activePage) && $activePage === 'sales' ? 'active' : ''; ?>"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="brand">Eyesightcollectibles</h1>
                <div class="welcome-text">Welcome Admin! <i class="fas fa-user-circle"></i></div>
            </div>

            <?php if (isset($content)) echo $content; ?>
        </div>
    </div>
</body>
</html> 