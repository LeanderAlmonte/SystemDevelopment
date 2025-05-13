<?php
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';
require_once __DIR__ . '/../../../Controllers/ClientController.php';
require_once __DIR__ . '/../../../Models/Client.php';

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Client - Eyesightcollectibles</title>
    <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
    
</head>
<body>
<div class="container">
    <div class="menu-panel">
        <h2 class="menu-title">Menu Panel</h2>
        <ul class="menu-items">
            <!-- keep same menu as in manage users -->
            <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/home"><i class="fas fa-home"></i><span>Home</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span>User Manual</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=clients" class="active"><i class="fas fa-user"></i><span>Manage Clients</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=product/manageInventory"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span>Sold Products</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users" class="active"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys"><i class="fas fa-history"></i><span>History</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/salesCosts"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=auths/logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
            <!-- add other menu links if needed -->
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 class="brand">Eyesightcollectibles</h1>
            <div class="welcome-text">Welcome Admin! <i class="fas fa-user-circle"></i></div>
        </div>

        <div class="add-user-container">
            <h2>New Client</h2>
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="/ecommerce/Project/SystemDevelopment/Views/clients/addClient.php" class="add-user-form">
                <div class="form-group">
                    <label for="clientName">Client Name</label>
                    <input type="text" id="clientName" name="clientName" placeholder="Client Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Phone Number" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Address" required>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/index.php?url=clients'">Back</button>
                    <button type="submit">Add Client</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
