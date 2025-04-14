<?php
$currentPage = basename($_SERVER['PHP_SELF']);
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';

use database\DBConnectionManager;

$dbManager = new DBConnectionManager();
$db = $dbManager->getConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Eyesightcollectibles</title>
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
                <li><a href="Resources/Views/dashboard/home.php"><i class="fas fa-home"></i><span>Home</span></a></li>
                <li><a href="Resources/Views/dashboard/manual.php"><i class="fas fa-book"></i><span>View Manual</span></a></li>
                <li><a href="Resources/Views/settings/settings.php" class="active"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                <li><a href="Resources/Views/users/users.php"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                <li><a href="Resources/Views/product/manageInventory.php"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                <li><a href="Resources/Views/product/soldProducts.php"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
                <li><a href="Resources/Views/product/archivedItems.php"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                <li><a href="Resources/Views/history/history.php"><i class="fas fa-history"></i><span>History</span></a></li>
                <li><a href="Resources/Views/sales/sales.php"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="brand">Eyesightcollectibles</h1>
                <div class="welcome-text">Welcome Admin! <i class="fas fa-user-circle"></i></div>
            </div>

            <div class="settings-container">
                <!-- Account Settings -->
                <h2>Account Setting</h2>
                <div class="settings-option">
                    <span>Change Password</span>
                    <button class="settings-btn">Change</button>
                </div>

                <!-- Preferences -->
                <h2>Preferences</h2>
                <div class="settings-option">
                    <span>Language Selection</span>
                    <select class="settings-btn">
                        <option value="en">English</option>
                        <option value="fr">French</option>
                    </select>
                </div>
                <div class="settings-option">
                    <span>Notification Settings</span>
                    <button class="settings-btn">Configure</button>
                </div>
                <div class="settings-option">
                    <span>Theme (Light/Dark Mode)</span>
                    <button class="settings-btn">Switch Theme</button>
                </div>

                <!-- Support -->
                <h2>Support</h2>
                <div class="settings-option">
                    <span>Contact Support</span>
                    <button class="settings-btn">Contact</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
