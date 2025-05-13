<?php

namespace Controllers;

use Models\User;
use RobThree\Auth\TwoFactorAuth;
use Resources\Views\Auth\Login;
use Resources\Views\Auth\Verify2FA;
use Core\TwoFA\EndroidQRCodeProvider;

require_once(dirname(__DIR__) . '/Models/User.php');
require_once(dirname(__DIR__) . '/Resources/Views/Auth/Login.php');
require_once(dirname(__DIR__) . '/Resources/Views/Auth/Verify2FA.php');
require_once(dirname(__DIR__) . '/Core/TwoFA/EndroidQRCodeProvider.php');

class AuthController {
    private User $user;
    private Login $loginView;
    private Verify2FA $verify2FAView;
    private TwoFactorAuth $tfa;
    private EndroidQRCodeProvider $qrCodeProvider;

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

            if (empty($email) || empty($password)) {
                $this->loginView->render('Please enter both email and password');
                return;
            }

            $user = $this->user->findByEmail($email);
            
            if ($user && password_verify($password, $user['password'])) {
                // Check if 2FA is enabled
                if ($user['twoFactorEnabled']) {
                    // Store user data in session for 2FA verification
                    $_SESSION['pending_user'] = $user;
                    header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/verify2fa');
                    exit();
                } else {
                    // Set session variables for regular login
                    $_SESSION['userID'] = $user['userID'];
                    $_SESSION['userName'] = $user['firstName'] . ' ' . $user['lastName'];
                    $_SESSION['userType'] = $user['userType'];
                    $_SESSION['twoFactorEnabled'] = $user['twoFactorEnabled'];
                    $_SESSION['lang'] = $user['language'] ?? 'en';
                    // Store userRole from login form (Employee/Admin), fallback to userType
                    $_SESSION['userRole'] = $_POST['userRole'] ?? $user['userType'];
                    
                    header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
                    exit();
                }
            } else {
                $this->loginView->render('Invalid email or password');
            }
        } else {
            $this->loginView->render();
        }
    }

    public function verify2FA() {
        if (!isset($_SESSION['pending_user'])) {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            $user = $_SESSION['pending_user'];

            if (empty($code)) {
                $_SESSION['error'] = 'Please enter the verification code';
                $this->verify2FAView->render();
                return;
            }

            if ($this->tfa->verifyCode($user['secretKey'], $code)) {
                // Clear pending user data
                unset($_SESSION['pending_user']);

                // Set session variables
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['userName'] = $user['firstName'] . ' ' . $user['lastName'];
                $_SESSION['userType'] = $user['userType'];
                $_SESSION['theme'] = $user['theme'];
                $_SESSION['twoFactorEnabled'] = $user['twoFactorEnabled'];
                $_SESSION['lang'] = $user['language'] ?? 'en';

                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
                exit();
            } else {
                $_SESSION['error'] = 'Invalid verification code';
                $this->verify2FAView->render();
            }
        } else {
            $this->verify2FAView->render();
        }
    }

    public function forgotPassword() {
        require_once dirname(__DIR__) . '/Resources/Views/Auth/ForgotPassword.php';
        $view = new \Resources\Views\Auth\ForgotPassword();
        $view->render();
    }
}
