<?php
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';
require_once __DIR__ . '/../../../Controllers/UserController.php';
require_once __DIR__ . '/../../../Models/User.php';

use controllers\UserController;

$userController = new UserController();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $userController->create($_POST);
    if (isset($result['error'])) {
        $error = $result['error'];
    } else {
        header('Location: users.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Eyesightcollectibles</title>
    <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .main-content {
            background-color: #f4f4f4;
            min-height: 100vh;
        }
        
        .add-user-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .add-user-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            margin: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: normal;
        }

        .form-group input,
        .form-group select {
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

        .form-actions button:hover {
            background-color: #f0f0f0;
        }

        .header {
            padding: 20px;
            background-color: #fff;
            margin-bottom: 20px;
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
            <h2 class="menu-title">Menu Panel</h2>
            <ul class="menu-items">
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/dashboard/home.php"><i class="fas fa-home"></i><span>Home</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/dashboard/manual.php"><i class="fas fa-book"></i><span>View Manual</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/settings/settings.php"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/users/users.php" class="active"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/product/manageInventory.php"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/product/soldProducts.php"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/product/archivedItems.php"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/history/history.php"><i class="fas fa-history"></i><span>History</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/sales/sales.php"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/Resources/Views/auth/logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="brand">Eyesightcollectibles</h1>
                <div class="welcome-text">Welcome Admin! <i class="fas fa-user-circle"></i></div>
            </div>

            <div class="add-user-container">
                <h2>New User</h2>
                <?php if (isset($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" class="add-user-form">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                    </div>

                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                        <label for="userType">User Type</label>
                        <select id="userType" name="userType" required>
                            <option value="" disabled selected>Select User Type</option>
                            <option value="admin">Admin</option>
                            <option value="user">Regular User</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="theme">Theme</label>
                        <select id="theme" name="theme" required>
                            <option value="" disabled selected>Select Theme</option>
                            <option value="light">Light</option>
                            <option value="dark">Dark</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" onclick="window.location.href='/ecommerce/Project/SystemDevelopment/Resources/Views/users/users.php'">Back</button>
                        <button type="submit">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 