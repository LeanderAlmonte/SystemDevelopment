<?php

namespace Controllers;

use Models\User;
use RobThree\Auth\TwoFactorAuth;
use Resources\Views\Settings\Settings;
use Resources\Views\Settings\Enable2FA;
use Resources\Views\Settings\Disable2FA;
use Resources\Views\Settings\ChangePassword;
use Core\TwoFA\EndroidQRCodeProvider;

require_once(dirname(__DIR__) . '/Models/User.php');
require_once(dirname(__DIR__) . '/Resources/Views/Settings/Settings.php');
require_once(dirname(__DIR__) . '/Resources/Views/Settings/Enable2FA.php');
require_once(dirname(__DIR__) . '/Resources/Views/Settings/Disable2FA.php');
require_once(dirname(__DIR__) . '/Resources/Views/Settings/ChangePassword.php');
require_once(dirname(__DIR__) . '/Core/TwoFA/EndroidQRCodeProvider.php');
require_once(dirname(__DIR__) . '/lang/lang.php');

class SettingController {
    private User $user;
    private Settings $settingsView;
    private Enable2FA $enable2FAView;
    private Disable2FA $disable2FAView;
    private ChangePassword $changePasswordView;
    private TwoFactorAuth $tfa;
    private EndroidQRCodeProvider $qrCodeProvider;

    public function __construct() {
        $this->user = new User();
        $this->settingsView = new Settings();
        $this->enable2FAView = new Enable2FA();
        $this->disable2FAView = new Disable2FA();
        $this->changePasswordView = new ChangePassword();
        $this->qrCodeProvider = new EndroidQRCodeProvider();
        $this->tfa = new TwoFactorAuth($this->qrCodeProvider, 'Eyesightcollectibles');
    }

    // Get user data (settings page)    
    public function read() {
        if (!isset($_SESSION['userID'])) {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
            exit();
        }

        $userData = $this->user->read($_SESSION['userID']);
        $_SESSION['twoFactorEnabled'] = $userData['twoFactorEnabled'] ?? false;
        $this->settingsView->render($userData);
    }

    // Update user settings (settings page) (I18N)
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
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings');
                exit;
            }
            // Handle theme change
            if (isset($_POST['switch_theme'])) {
                $newTheme = ($_SESSION['theme'] ?? 'Light') === 'Light' ? 'Dark' : 'Light';
                $_SESSION['theme'] = $newTheme;
                setcookie('theme', $newTheme, time() + (86400 * 30), "/"); // Store theme in a cookie for 30 days
                
                // Update theme in database
                if (isset($_SESSION['userID'])) {
                    $user = new User();
                    $user->setUserID($_SESSION['userID']);
                    $userData = $user->read($_SESSION['userID']);
                    if ($userData) {
                        $user->setFirstName($userData['firstName']);
                        $user->setLastName($userData['lastName']);
                        $user->setEmail($userData['email']);
                        $user->setUserType($userData['userType']);
                        $user->setTheme($newTheme);
                        $user->setLanguage($userData['language']);
                        $user->update();
                    }
                }
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings');
                exit;
            }
        }
    }

    // Enable 2FA (settings page)
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

    // Verify 2FA (settings page)
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

    // Disable 2FA (settings page)
    public function disable2FA() {
        if (!isset($_SESSION['userID'])) {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            
            // Get the user's secret key
            $userData = $this->user->read($_SESSION['userID']);
            $secret = $userData['secretKey'];
            
            // Verify the code using the tfa instance
            if ($this->tfa->verifyCode($secret, $code)) {
                // Update user's 2FA status in database
                $this->user->update2FASettings($_SESSION['userID'], null, false);
                
                // Set success message
                $_SESSION['success'] = lang('2fa_disabled_success');
                
                // Redirect back to settings
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings');
                exit;
            } else {
                // Show error message
                $this->disable2FAView->render(lang('invalid_verification_code'));
                return;
            }
        }

        // Check if 2FA is enabled
        if (!$this->user->is2FAEnabled($_SESSION['userID'])) {
            $_SESSION['error'] = lang('2fa_not_enabled');
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings');
            exit;
        }

        // Show the disable 2FA form
        $this->disable2FAView->render();
    }

    // Change password (settings page)
    public function changePassword() {
        if (!isset($_SESSION['userID'])) {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['currentPassword'] ?? '';
            $newPassword = $_POST['newPassword'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            // Validate input
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $this->changePasswordView->render('All fields are required');
                return;
            }

            if ($newPassword !== $confirmPassword) {
                $this->changePasswordView->render('New passwords do not match');
                return;
            }

            if (strlen($newPassword) < 6) {
                $this->changePasswordView->render('New password must be at least 6 characters long');
                return;
            }

            // Get current user data
            $userData = $this->user->read($_SESSION['userID']);
            
            // Verify current password
            if (!password_verify($currentPassword, $userData['password'])) {
                $this->changePasswordView->render('Current password is incorrect');
                return;
            }

            // Update password while preserving other user data
            $this->user->setUserID($_SESSION['userID']);
            $this->user->setFirstName($userData['firstName']);
            $this->user->setLastName($userData['lastName']);
            $this->user->setEmail($userData['email']);
            $this->user->setUserType($userData['userType']);
            $this->user->setTheme($userData['theme']);
            $this->user->setLanguage($userData['language']);
            $this->user->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));
            
            if ($this->user->update()) {
                $_SESSION['success'] = 'Password changed successfully';
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=settings');
                exit();
            } else {
                $this->changePasswordView->render('Failed to update password. Please try again.');
            }
        } else {
            $this->changePasswordView->render();
        }
    }
} 