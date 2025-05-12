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
require_once(dirname(__DIR__) . '/lang/lang.php');

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
            if (isset($_POST['lang'])) {
                $_SESSION['lang'] = $_POST['lang'];
                // Persist to DB for user profile
                if (isset($_SESSION['userID'])) {
                    $user = new User();
                    $user->setUserID($_SESSION['userID']);
                    $userData = $user->read($_SESSION['userID']);
                    $user->setFirstName($userData['firstName']);
                    $user->setLastName($userData['lastName']);
                    $user->setEmail($userData['email']);
                    $user->setUserType($userData['userType']);
                    $user->setTheme($userData['theme']);
                    $user->setLanguage($_POST['lang']);
                    $user->update();
                }
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
            // Handle other settings update logic here
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
                $_SESSION['error'] = 'Invalid verification code. Please try again.';
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings/enable2fa');
                exit();
            }
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