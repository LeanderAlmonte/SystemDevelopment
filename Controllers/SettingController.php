<?php

namespace Controllers;

use Resources\Views\Settings\Settings;

require_once(dirname(__DIR__) . '/Resources/Views/Settings/Settings.php');
require_once(dirname(__DIR__) . '/lang/lang.php');

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
                // Optionally, persist to DB for user profile here
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
            // Handle other settings update logic here
        }
    }
} 