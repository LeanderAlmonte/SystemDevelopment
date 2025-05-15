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

    // Get all users (users page)
    public function read() {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        $data = $this->user->read();
        $manageUsers = new ManageUsers();
        $manageUsers->render($data);
    }

    // Create a new user (add user page)
    public function create() {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postData = $_POST;
            if (!isset($postData['theme']) || empty($postData['theme'])) {
                $postData['theme'] = 'Light';
            }
            // Capitalize first letter of each word in first and last names, including after hyphens
            $postData['firstName'] = preg_replace_callback('/\b\w|-\w/', function($matches) { return strtoupper($matches[0]); }, strtolower($postData['firstName']));
            $postData['lastName'] = preg_replace_callback('/\b\w|-\w/', function($matches) { return strtoupper($matches[0]); }, strtolower($postData['lastName']));
            // Check for duplicate email
            $existingUser = $this->user->findByEmail($postData['email']);
            if ($existingUser) {
                $this->showAddForm('A user with this email already exists.', $postData['firstName'], $postData['lastName']);
                return;
            }
            $result = $this->user->create($postData);
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

    // Delete a user (users page)
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

    // Show add user form (add user page)
    private function showAddForm($error = null, $firstName = '', $lastName = '') {
        if (!isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'Admin') {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=dashboards');
            exit();
        }
        require_once(dirname(__DIR__) . '/resources/views/user/addUser.php');
        $view = new \Resources\Views\User\Adduser();
        $view->render($error, $firstName, $lastName);
        exit();
    }

    // Update a user (edit user page)
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
            if (isset($_POST['userType'])) {
                $user->setUserType($_POST['userType']);
            }

            // Get current user data to preserve userType
            $currentUser = $user->read($_POST['userID']);
            if ($currentUser) {
                // If userType is not set from the form, preserve the old one
                if (!isset($_POST['userType'])) {
                    $user->setUserType($currentUser['userType']);
                }
                $user->setLanguage($currentUser['language'] ?? 'en');
            }

            if ($user->update()) {
                // If the current user is being edited, update their session role immediately
                if (isset($_SESSION['userID']) && $_SESSION['userID'] == $_POST['userID'] && isset($_POST['userType'])) {
                    $_SESSION['userRole'] = $_POST['userType'];
                    $_SESSION['userType'] = $_POST['userType'];
                }
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
