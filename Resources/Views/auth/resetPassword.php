<?php
namespace Resources\Views\Auth;

class ResetPassword {
    public function render($email, $token, $error = null, $success = null) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset Password - Eyesightcollectibles</title>
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
                    <h2>Reset Password</h2>
                    <?php if (isset($error)): ?>
                        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <div class="success-message"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=auths/resetPassword">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter new password" required>
                        <label for="confirm">Confirm Password</label>
                        <input type="password" id="confirm" name="confirm" placeholder="Confirm new password" required>
                        <button type="submit" class="submit-button">Reset Password</button>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}
