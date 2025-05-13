<?php
namespace Resources\Views\User;

use Controllers\UserController;

class Adduser {
    public function render($error = null) {
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
            <h2 class="menu-title"><?php echo lang('menu_panel'); ?></h2>
            <ul class="menu-items">
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/home"><i class="fas fa-home"></i><span><?php echo lang('home'); ?></span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span><?php echo lang('view_manual'); ?></span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings"><i class="fas fa-cog"></i><span><?php echo lang('settings'); ?></span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=product/manageInventory"><i class="fas fa-box"></i><span><?php echo lang('manage_inventory'); ?></span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span><?php echo lang('view_sold_products'); ?></span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span><?php echo lang('archived_items'); ?></span></a></li>
                <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users" class="active"><i class="fas fa-users"></i><span><?php echo lang('manage_users'); ?></span></a></li>
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

                    <div class="add-user-container">
                        <h2><?php echo lang('new_user'); ?></h2>
                        <?php if (isset($error)): ?>
                            <div class="error-message"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=users" class="add-user-form">
                            <div class="form-group">
                                <label for="firstName"><?php echo lang('first_name'); ?></label>
                                <input type="text" id="firstName" name="firstName" placeholder="<?php echo lang('first_name'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="lastName"><?php echo lang('last_name'); ?></label>
                                <input type="text" id="lastName" name="lastName" placeholder="<?php echo lang('last_name'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email"><?php echo lang('email'); ?></label>
                                <input type="email" id="email" name="email" placeholder="<?php echo lang('email'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="password"><?php echo lang('password'); ?></label>
                                <input type="password" id="password" name="password" placeholder="<?php echo lang('password'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="userType"><?php echo lang('user_type'); ?></label>
                                <select id="userType" name="userType" required>
                                    <option value="" disabled selected><?php echo lang('select_user_type'); ?></option>
                                    <option value="Admin"><?php echo lang('admin'); ?></option>
                                    <option value="Employee"><?php echo lang('employee'); ?></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="theme"><?php echo lang('theme'); ?></label>
                                <select id="theme" name="theme" required>
                                    <option value="" disabled selected><?php echo lang('select_theme'); ?></option>
                                    <option value="Light"><?php echo lang('light'); ?></option>
                                    <option value="Dark"><?php echo lang('dark'); ?></option>
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
        </body>
        </html>
        <?php
    }
} 