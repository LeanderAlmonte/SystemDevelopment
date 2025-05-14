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
            $id = $_POST['userId'] ?? null;
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
            $id = $_POST['userID'] ?? null;
            if ($id) {
                // Get the current user data
                $currentUser = $this->user->read($id);
                
                $this->user->setUserID($id);
                $this->user->setFirstName($_POST['firstName']);
                $this->user->setLastName($_POST['lastName']);
                $this->user->setEmail($_POST['email']);
                
                // Preserve case for userType
                $userType = $_POST['userType'];
                if ($userType === 'admin') {
                    $userType = 'Admin';
                } elseif ($userType === 'employee') {
                    $userType = 'Employee';
                }
                $this->user->setUserType($userType);
                
                // Preserve case for theme
                $theme = $_POST['theme'];
                if ($theme === 'light') {
                    $theme = 'Light';
                } elseif ($theme === 'dark') {
                    $theme = 'Dark';
                }
                $this->user->setTheme($theme);
                
                $result = $this->user->update();
                if (!$result) {
                    $this->showEditForm($id, 'Failed to update user');
                    return;
                }
                
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=users');
                exit();
            }
        } else {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $this->showEditForm($id);
            } else {
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=users');
                exit();
            }
        }
    }

    private function showEditForm($id, $error = null) {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        $data = ['user' => $this->user->read($id)];
        require(dirname(__DIR__) . '/resources/views/user/editUser.php');
        $editUser = new \resources\views\user\EditUser();
        $editUser->render($data, $error);
        exit();
    }
}
