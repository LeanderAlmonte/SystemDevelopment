<?php

namespace views\auth;

class Login {
    public function render($error = null) {
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

                    <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=auths/login">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        
                        <a href="#" class="forgot-password">Forgot Password?</a>
                        <button type="submit" class="submit-button">Login</button>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
} 