<?php
namespace views\auth;

class ForgotPassword {
    public function render($error = null) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Forgot Password - Eyesightcollectibles</title>
            <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/forgotpass.css">
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
                    <h2>Forgot Password?</h2>
                    <h5>Please enter your email to reset the password</h5>

                    <?php if (isset($error)): ?>
                        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=auths/sendcode">
                        <label for="email">Your Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        <button type="submit" class="send-code">Send Code</button>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}
