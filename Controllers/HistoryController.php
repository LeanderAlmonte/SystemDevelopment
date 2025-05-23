<?php

namespace Controllers;

use models\Action;
use Resources\Views\History\History;

class HistoryController {
    private $actionModel;
    private $historyView;

    public function __construct() {
        $this->actionModel = new Action();
        $this->historyView = new History();
    }

    // Get all actions (history page)
    public function read() {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        // Get all actions from the model
        $actions = $this->actionModel->read();
        
        // Render the view with the actions data
        $this->historyView->render($actions);
    }

    // Get actions by user ID (history page)
    public function getByUser($userID) {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        $actions = $this->actionModel->getByUserID($userID);
        $this->historyView->render($actions);
    }

    // Get actions by product ID (history page)
    public function getByProduct($productID) {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        $actions = $this->actionModel->getByProductID($productID);
        $this->historyView->render($actions);
    }

    // Get actions by client ID (history page)
    public function getByClient($clientID) {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        $actions = $this->actionModel->getByClientID($clientID);
        $this->historyView->render($actions);
    }
} 