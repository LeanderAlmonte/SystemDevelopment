<?php

namespace views\auth;

class Login {
    public function render($error = null) {
        // Debug output
        /*
        echo "<div style='background: #f0f0f0; padding: 10px; margin: 10px; border: 1px solid #ccc;'>";
        echo "<h3>Debug Information:</h3>";
        echo "<pre>";
        echo "POST data: ";
        print_r($_POST);
        echo "\nSession data: ";
        print_r($_SESSION);
        echo "</pre>";
        echo "</div>";
        */
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Eyesightcollectibles Login</title>
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
                    <h2>Login</h2>
                    
                    <?php if (isset($error)): ?>
                        <div class="error-message"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=auths/login">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        
                        <a href="/ecommerce/Project/SystemDevelopment/index.php?url=auths/forgotPassword" class="forgot-password">Forgot Password?</a>
                        <button type="submit" class="submit-button">Login</button>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
} 