<?php

namespace Controllers;

use Resources\Views\Dashboard\Home;
use Resources\Views\Dashboard\Manual;

// require_once(dirname(__DIR__) . '/Resources/Views/Dashboard/Home.php');
require_once(dirname(__DIR__) . '/Resources/Views/Dashboard/Manual.php');

class DashboardController {
    private Home $homeView;
    private Manual $manualView;

    public function __construct() {
        // $this->homeView = new Home();
        $this->manualView = new Manual();
    }

    public function read() {
        $this->homeView->render();
    }

    public function manual() {
        $this->manualView->render();
    }
} 