<?php

namespace Controllers;

use Resources\Views\Settings\Settings;

require_once(dirname(__DIR__) . '/Resources/Views/Settings/Settings.php');
require_once(dirname(__DIR__) . '/helpers/lang.php');

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
            // Handle settings update logic here
            // For example: update password, theme, etc.
        }
    }
} 