<?php

namespace Controllers;

use Models\User;
use RobThree\Auth\TwoFactorAuth;
use Views\Auth\Login;
use Views\Auth\Verify2FA;
use Core\TwoFA\EndroidQRCodeProvider;

require_once(dirname(__DIR__) . '/Models/User.php');
require_once(dirname(__DIR__) . '/Resources/Views/Auth/Login.php');
require_once(dirname(__DIR__) . '/Resources/Views/Auth/Verify2FA.php');
require_once(dirname(__DIR__) . '/Core/TwoFA/EndroidQRCodeProvider.php');

class AuthController {
    private User $user;
    private Login $loginView;
    private Verify2FA $verify2FAView;

    public function __construct() {
        $this->user = new User();
        $this->loginView = new Login();
        $this->verify2FAView = new Verify2FA();
        $this->qrCodeProvider = new EndroidQRCodeProvider();
        $this->tfa = new TwoFactorAuth($this->qrCodeProvider, 'Eyesightcollectibles');
    }

    public function read() {
        $this->loginView->render();
    }

    public function logout() {
        session_destroy();
        header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
        exit();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Debug information
            error_log("Login attempt - Email: " . $email);
            error_log("POST data: " . print_r($_POST, true));
            error_log("Session data: " . print_r($_SESSION, true));

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Please enter both email and password.';
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
                exit();
            }

            $user = $this->user->findByEmail($email);
            error_log("User found: " . ($user ? "Yes" : "No"));

            if ($user && password_verify($password, $user['password'])) {
                error_log("Password verified successfully");
                error_log("2FA enabled: " . ($user['twoFactorEnabled'] ? "Yes" : "No"));

                if ($user['twoFactorEnabled']) {
                    // Store user data in session for 2FA verification
                    $_SESSION['pending_user'] = $user;
                    error_log("Redirecting to 2FA verification");
                    header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/verify2fa');
                    exit();
                } else {
                    // Set session variables
                    $_SESSION['userID'] = $user['userID'];
                    $_SESSION['userName'] = $user['firstName'] . ' ' . $user['lastName'];
                    $_SESSION['userType'] = $user['userType'];
                    $_SESSION['theme'] = $user['theme'];
                    $_SESSION['twoFactorEnabled'] = $user['twoFactorEnabled'];

                    error_log("Redirecting to dashboard");
                    header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
                    exit();
                }
            } else {
                error_log("Login failed - Invalid credentials");
                $_SESSION['error'] = 'Invalid email or password.';
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
                exit();
            }
        }

        $this->loginView->render();
    }

    public function verify2FA() {
        // Debug information
        /*
        error_log("=== Verify2FA Method Called ===");
        error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("Full Session Data: " . print_r($_SESSION, true));
        error_log("Current URL: " . $_SERVER['REQUEST_URI']);
        error_log("GET params: " . print_r($_GET, true));
        error_log("POST params: " . print_r($_POST, true));
        */

        // If there's no pending user but we have a userID, we're already logged in
        if (!isset($_SESSION['pending_user']) && isset($_SESSION['userID'])) {
            //error_log("User already logged in, redirecting to dashboard");
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }

        // If there's no pending user and no userID, we need to log in first
        if (!isset($_SESSION['pending_user'])) {
            //error_log("No pending user found in session");
            $_SESSION['error'] = 'Please log in first.';
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            //error_log("2FA code submitted: " . $code);
            
            if (empty($code)) {
                $_SESSION['error'] = 'Please enter the 2FA code.';
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/verify2fa');
                exit();
            }

            $user = $_SESSION['pending_user'];
            $tfa = new TwoFactorAuth($this->qrCodeProvider, 'Eyesightcollectibles');

            //error_log("Verifying code for user: " . $user['email']);
            //error_log("Secret key: " . $user['secretKey']);

            if ($tfa->verifyCode($user['secretKey'], $code)) {
                //error_log("2FA verification successful");
                // Set session variables
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['userName'] = $user['firstName'] . ' ' . $user['lastName'];
                $_SESSION['userType'] = $user['userType'];
                $_SESSION['theme'] = $user['theme'];
                $_SESSION['twoFactorEnabled'] = $user['twoFactorEnabled'];

                // Clear pending user data
                unset($_SESSION['pending_user']);

                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
                exit();
            } else {
                //error_log("2FA verification failed");
                $_SESSION['error'] = 'Invalid 2FA code. Please try again.';
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/verify2fa');
                exit();
            }
        }

        //error_log("Rendering verify2FA view");
        $this->verify2FAView->render();
    }
}
