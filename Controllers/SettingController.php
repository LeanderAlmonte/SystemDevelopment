<?php

namespace Controllers;

use Resources\Views\Settings\Settings;
use Models\User;

require_once(dirname(__DIR__) . '/Resources/Views/Settings/Settings.php');
require_once(dirname(__DIR__) . '/lang/lang.php');
require_once(dirname(__DIR__) . '/Models/User.php');

class SettingController {
    private Settings $settingsView;

    public function __construct() {
        $this->settingsView = new Settings();
    }

    public function read() {
        $this->settingsView->render();
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
} 