<?php
namespace Views\Auth;

class Verify2FA {
    public function render() {
        // Debug output
        /*
        echo "<div style='background: #f0f0f0; padding: 10px; margin: 10px; border: 1px solid #ccc;'>";
        echo "<h3>Debug Information:</h3>";
        echo "<pre>";
        echo "Session data: ";
        print_r($_SESSION);
        echo "\nRequest Method: " . $_SERVER['REQUEST_METHOD'];
        echo "\nCurrent URL: " . $_SERVER['REQUEST_URI'];
        echo "</pre>";
        echo "</div>";
        */
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Verify 2FA - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/login.css">
        </head>
        <body>
            <div class="container">
                <div class="logo">
                    <div class="image-container">
                        <img src="/ecommerce/Project/SystemDevelopment/assets/css/images/logo.jpg" alt="Character">
                    </div>
                </div>
                <div class="login-form">
                    <h1>Eyesightcollectibles</h1>
                    <h2>Two-Factor Authentication</h2>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error-message">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=auths/verify2fa">
                        <label for="code">Enter the 6-digit code from your authenticator app</label>
                        <input type="text" id="code" name="code" placeholder="Enter 6-digit code" required autocomplete="off" maxlength="6" pattern="[0-9]{6}">
                        
                        <button type="submit" class="submit-button">Verify</button>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
} 