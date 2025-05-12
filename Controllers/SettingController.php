<?php

namespace Controllers;

use Models\User;
use RobThree\Auth\TwoFactorAuth;
use Resources\Views\Settings\Settings;
use Resources\Views\Settings\Enable2FA;
use Core\TwoFA\EndroidQRCodeProvider;

require_once(dirname(__DIR__) . '/Models/User.php');
require_once(dirname(__DIR__) . '/Resources/Views/Settings/Settings.php');
require_once(dirname(__DIR__) . '/Resources/Views/Settings/Enable2FA.php');
require_once(dirname(__DIR__) . '/Core/TwoFA/EndroidQRCodeProvider.php');

class SettingController {
    private User $user;
    private Settings $settingsView;
    private Enable2FA $enable2FAView;
    private TwoFactorAuth $tfa;
    private EndroidQRCodeProvider $qrCodeProvider;

    public function __construct() {
        $this->user = new User();
        $this->settingsView = new Settings();
        $this->enable2FAView = new Enable2FA();
        $this->qrCodeProvider = new EndroidQRCodeProvider();
        $this->tfa = new TwoFactorAuth($this->qrCodeProvider, 'Eyesightcollectibles');
    }

    public function read() {
        if (!isset($_SESSION['userID'])) {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
            exit();
        }

        $userData = $this->user->read($_SESSION['userID']);
        $this->settingsView->render($userData);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle settings update logic here
            // For example: update password, theme, etc.
        }
    }

    public function enable2FA() {
        if (!isset($_SESSION['userID'])) {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $secret = $this->tfa->createSecret();
            $qrCodeUrl = $this->tfa->getQRCodeImageAsDataUri('Eyesightcollectibles', $secret);
            
            $this->enable2FAView->render($secret, $qrCodeUrl);
        } else {
            $this->enable2FAView->render();
        }
    }

    public function verify2FA() {
        if (!isset($_SESSION['userID'])) {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            $secret = $_POST['secret'] ?? '';

            // Add debugging information immediately
            $_SESSION['debug_info'] = [
                'entered_code' => $code,
                'secret' => $secret,
                'verification_result' => $this->tfa->verifyCode($secret, $code),
                'timestamp' => date('Y-m-d H:i:s'),
                'user_id' => $_SESSION['userID']
            ];

            if (empty($code) || empty($secret)) {
                $_SESSION['error'] = 'Please enter the verification code.';
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings/enable2fa');
                exit();
            }

            if ($this->tfa->verifyCode($secret, $code)) {
                // Update user's 2FA settings
                $updateResult = $this->user->update2FASettings($_SESSION['userID'], $secret, true);
                
                if ($updateResult) {
                    $_SESSION['twoFactorEnabled'] = true;
                    header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings');
                    exit();
                } else {
                    $_SESSION['error'] = 'Failed to enable 2FA. Database update failed.';
                    header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings/enable2fa');
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Invalid verification code. Please try again. Make sure you\'re using the most recent code from your authenticator app.';
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings/enable2fa');
                exit();
            }
        } else {
            // If it's a GET request, show the form with any existing debug info
            $this->enable2FAView->render();
        }
    }

    public function disable2FA() {
        if (!isset($_SESSION['userID'])) {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            $userData = $this->user->read($_SESSION['userID']);

            if (empty($code)) {
                $_SESSION['error'] = 'Please enter the verification code.';
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings');
                exit();
            }

            if ($this->tfa->verifyCode($userData['secretKey'], $code)) {
                // Update user's 2FA settings
                if ($this->user->update2FASettings($_SESSION['userID'], null, false)) {
                    $_SESSION['twoFactorEnabled'] = false;
                    header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings');
                    exit();
                } else {
                    $_SESSION['error'] = 'Failed to disable 2FA. Please try again.';
                    header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings');
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Invalid verification code. Please try again.';
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings');
                exit();
            }
        }
    }
} 