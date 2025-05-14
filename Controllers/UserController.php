<?php

namespace controllers;

use models\User;

use views\user\ManageUsers;

require(dirname(__DIR__) . '/resources/views/user/manageUsers.php');
require(dirname(__DIR__) . '/models/User.php');

class UserController {

    private User $user;

    public function __construct() {
        $this->user = new User();
    }

    public function read() {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        $data = $this->user->read();
        $manageUsers = new ManageUsers();
        $manageUsers->render($data);
    }

    public function create() {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->user->create($_POST);
            if (isset($result['error'])) {
                $this->showAddForm($result['error']);
            } else {
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=users');
                exit();
            }
        } else {
            $this->showAddForm();
        }
    }

    public function delete() {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['userID'] ?? null;
            if ($id) {
                $this->user->setUserID($id);
                $result = $this->user->delete();
                if (!$result) {
                    echo "<script>alert('Error: Failed to delete user');</script>";
                }
            }
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=users');
            exit();
        }
    }

    private function showAddForm($error = null) {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        require_once(dirname(__DIR__) . '/resources/views/user/addUser.php');
        $view = new \Resources\Views\User\Adduser();
        $view->render($error);
        exit();
    }

    public function update() {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $user->setUserID($_POST['userID']);
            $user->setFirstName($_POST['firstName']);
            $user->setLastName($_POST['lastName']);
            $user->setEmail($_POST['email']);
            $user->setTheme($_POST['theme']);

            // Get current user data to preserve userType
            $currentUser = $user->read($_POST['userID']);
            if ($currentUser) {
                $user->setUserType($currentUser['userType']);
                $user->setLanguage($currentUser['language'] ?? 'en');
            }

            if ($user->update()) {
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=users');
                exit();
            } else {
                $error = "Failed to update user";
                $userData = $user->read($_POST['userID']);
                $view = new \resources\views\user\EditUser();
                $view->render(['user' => $userData], $error);
            }
        } else {
            // Handle GET request
            $user = new User();
            $userData = $user->read($_GET['id']);
            if ($userData) {
                $view = new \resources\views\user\EditUser();
                $view->render(['user' => $userData]);
            } else {
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=users');
                exit();
            }
        }
    }
}
