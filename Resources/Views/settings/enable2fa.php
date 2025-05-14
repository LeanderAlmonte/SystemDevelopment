<?php
namespace Resources\Views\Settings;

use RobThree\Auth\TwoFactorAuth;

class Enable2FA {
    public function render($secret = null, $qrCodeUrl = null) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Enable 2FA - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <?php
            // Include dark theme CSS if the selected theme is Dark
            if ($_SESSION['theme'] === 'Dark') {
                echo '<link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/dark.css">';
            }
            ?>
        </head>
        <body<?php 
            $theme = $_SESSION['theme'] ?? 'Light';
            echo $theme === 'Dark' ? ' class="dark-theme"' : '';
        ?>>
            <div class="container">
                <!-- Menu Panel -->
                <div class="menu-panel">
                    <h2 class="menu-title">Menu Panel</h2>
                    <ul class="menu-items">
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards"><i class="fas fa-home"></i><span>Home</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=dashboards/manual"><i class="fas fa-book"></i><span>View Manual</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=settings" class="active"><i class="fas fa-cog"></i><span>Settings</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=users"><i class="fas fa-users"></i><span>Manage Users</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products"><i class="fas fa-box"></i><span>Manage Inventory</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/soldProducts"><i class="fas fa-shopping-cart"></i><span>View sold products</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/archive"><i class="fas fa-archive"></i><span>Archived Items</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=historys"><i class="fas fa-history"></i><span>History</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=products/salesCosts"><i class="fas fa-chart-line"></i><span>Sales/Costs</span></a></li>
                        <li><a href="/ecommerce/Project/SystemDevelopment/index.php?url=auths/logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <div class="header">
                        <h1 class="brand">Eyesightcollectibles</h1>
                        <div class="welcome-text">Welcome <?php echo explode(' ', $_SESSION['userName'])[0]; ?>! <i class="fas fa-user-circle"></i></div>
                    </div>

                    <div class="settings-container">
                        <h2>Enable Two-Factor Authentication</h2>
                        
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="error-message">
                                <?php 
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']); // Clear the error after displaying
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['debug_info'])): ?>
                            <div class="debug-info">
                                <h3>Debug Information:</h3>
                                <div class="debug-content">
                                    <p><strong>Entered Code:</strong> <?php echo htmlspecialchars($_SESSION['debug_info']['entered_code']); ?></p>
                                    <p><strong>Secret Key:</strong> <?php echo htmlspecialchars($_SESSION['debug_info']['secret']); ?></p>
                                    <p><strong>Verification Result:</strong> <?php echo $_SESSION['debug_info']['verification_result'] ? 'True' : 'False'; ?></p>
                                    <p><strong>Timestamp:</strong> <?php echo htmlspecialchars($_SESSION['debug_info']['timestamp']); ?></p>
                                </div>
                                <?php unset($_SESSION['debug_info']); // Clear debug info after displaying ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['debug_db'])): ?>
                            <div class="debug-info">
                                <h3>Database Update Information:</h3>
                                <div class="debug-content">
                                    <?php if (isset($_SESSION['debug_db']['error'])): ?>
                                        <p class="error"><strong>Error:</strong> <?php echo htmlspecialchars($_SESSION['debug_db']['error']); ?></p>
                                    <?php else: ?>
                                        <p><strong>Query:</strong> <?php echo htmlspecialchars($_SESSION['debug_db']['query']); ?></p>
                                        <p><strong>Parameters:</strong> <?php echo htmlspecialchars(json_encode($_SESSION['debug_db']['params'])); ?></p>
                                        <p><strong>Result:</strong> <?php echo $_SESSION['debug_db']['result'] ? 'Success' : 'Failed'; ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php unset($_SESSION['debug_db']); // Clear debug info after displaying ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($secret && $qrCodeUrl): ?>
                            <div class="2fa-setup">
                                <p>1. Scan this QR code with your authenticator app:</p>
                                <div class="qr-code">
                                    <img src="<?php echo $qrCodeUrl; ?>" alt="2FA QR Code">
                                </div>
                                
                                <p>2. Or manually enter this secret key:</p>
                                <div class="secret-key">
                                    <code><?php echo $secret; ?></code>
                                </div>
                                
                                <p>3. Enter the code from your authenticator app to verify:</p>
                                <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=settings/verify2fa">
                                    <input type="text" name="code" placeholder="Enter 6-digit code" required>
                                    <input type="hidden" name="secret" value="<?php echo $secret; ?>">
                                    <button type="submit" class="settings-btn">Verify and Enable 2FA</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="2fa-info">
                                <p>Two-factor authentication adds an extra layer of security to your account. 
                                   When enabled, you'll need to enter a code from your authenticator app in addition to your password when logging in.</p>
                                <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=settings/enable2fa">
                                    <button type="submit" class="settings-btn">Start Setup</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <style>
                .2fa-setup {
                    max-width: 400px;
                    margin: 20px auto;
                    padding: 20px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }

                .dark-theme .2fa-setup {
                    background: #2d2d2d;
                    color: #fff;
                }

                .qr-code {
                    text-align: center;
                    margin: 20px 0;
                }

                .qr-code img {
                    max-width: 200px;
                    height: auto;
                }

                .secret-key {
                    background: #f5f5f5;
                    padding: 10px;
                    border-radius: 4px;
                    margin: 10px 0;
                    text-align: center;
                }

                .dark-theme .secret-key {
                    background: #3d3d3d;
                    color: #fff;
                }

                .secret-key code {
                    font-family: monospace;
                    font-size: 16px;
                }

                .2fa-info {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }

                .dark-theme .2fa-info {
                    background: #2d2d2d;
                    color: #fff;
                }

                .2fa-info p {
                    margin-bottom: 20px;
                    line-height: 1.6;
                }

                input[type="text"] {
                    width: 100%;
                    padding: 10px;
                    margin: 10px 0;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    font-size: 16px;
                }

                .dark-theme input[type="text"] {
                    background: #3d3d3d;
                    color: #fff;
                    border-color: #444;
                }

                .settings-btn {
                    width: 100%;
                    padding: 10px;
                    background-color: #ff6b00;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    font-size: 16px;
                }

                .settings-btn:hover {
                    background-color: #e65c00;
                }

                .error-message {
                    background-color: #ffebee;
                    color: #c62828;
                    padding: 10px;
                    border-radius: 4px;
                    margin-bottom: 20px;
                    border: 1px solid #ef9a9a;
                }

                .dark-theme .error-message {
                    background-color: #3d2d2d;
                    color: #ff9a9a;
                    border-color: #ff6b6b;
                }

                .debug-info {
                    background-color: #e3f2fd;
                    color: #1565c0;
                    padding: 15px;
                    border-radius: 4px;
                    margin-bottom: 20px;
                    border: 1px solid #90caf9;
                }

                .dark-theme .debug-info {
                    background-color: #2d3d4d;
                    color: #90caf9;
                    border-color: #1565c0;
                }

                .debug-info h3 {
                    margin-top: 0;
                    color: #1565c0;
                    font-size: 16px;
                }

                .dark-theme .debug-info h3 {
                    color: #90caf9;
                }

                .debug-content {
                    background-color: #fff;
                    padding: 10px;
                    border-radius: 4px;
                    border: 1px solid #90caf9;
                }

                .dark-theme .debug-content {
                    background-color: #1d2d3d;
                    border-color: #1565c0;
                }

                .debug-content p {
                    margin: 5px 0;
                    font-family: monospace;
                }
            </style>
        </body>
        </html>
        <?php
    }
} 