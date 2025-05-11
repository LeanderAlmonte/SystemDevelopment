<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eyesightcollectibles - Verify Code</title>
    <link rel="stylesheet" href="/ecommerce/Project/SystemDevelopment/assets/css/verifypage.css">
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
            <h2>Check Your Email</h2>
            <h5>
                We sent a reset code to your email.<br>
                Enter the 6-digit code below.
            </h5>

            <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=auths/verifycode" onsubmit="combineCode(event)">
                <div class="code-input-container">
                    <input type="text" maxlength="1" class="code-input" required>
                    <input type="text" maxlength="1" class="code-input" required>
                    <input type="text" maxlength="1" class="code-input" required>
                    <input type="text" maxlength="1" class="code-input" required>
                    <input type="text" maxlength="1" class="code-input" required>
                    <input type="text" maxlength="1" class="code-input" required>
                </div>
                <input type="hidden" name="code" id="fullCode">
                <button type="submit" class="verify-code">Verify Code</button>
            </form>

            <h3>Haven't got the email yet?
                <form method="POST" action="/ecommerce/Project/SystemDevelopment/index.php?url=auths/forgotpassword" style="display:inline;">
                    <button type="submit" class="resend">Resend Email</button>
                </form>
            </h3>
        </div>
    </div>

    <script>
        function combineCode(event) {
            const inputs = document.querySelectorAll('.code-input');
            let code = '';
            inputs.forEach(input => code += input.value);
            document.getElementById('fullCode').value = code;
        }

        // Optional: Auto-focus next input
        const inputs = document.querySelectorAll('.code-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });
    </script>
</body>
</html>
