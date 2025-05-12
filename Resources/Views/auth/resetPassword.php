<!-- File: Resources/Views/Auth/resetpassword.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eyesightcollectibles - Reset Password</title>
    <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/setpass.css">
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
            <h2>Set a New Password</h2>
            <h5>Create a new password. Ensure it differs from<br>previous ones for security.</h5>

            <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=auths/updatePassword">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your new password" required>

                <label for="confirm">Confirm New Password</label>
                <input type="password" id="confirm" name="confirm" placeholder="Confirm your new password" required>

                <button type="submit" class="submit-button">Update Password</button>
            </form>
        </div>
    </div>
</body>
</html>
