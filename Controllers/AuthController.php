<?php

namespace Controllers;

use Models\User;
use Views\Auth\Login;

require_once(dirname(__DIR__) . '/Models/User.php');
require_once(dirname(__DIR__) . '/Resources/Views/Auth/Login.php');

class AuthController {
    private User $user;
    private Login $loginView;

    public function __construct() {
        $this->user = new User();
        $this->loginView = new Login();
    }

    public function read() {
        $this->loginView->render();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validate input
            if (empty($email) || empty($password)) {
                $this->loginView->render('Please enter both email and password');
                return;
            }

            // Get all users from database
            $users = $this->user->read();
            $authenticatedUser = null;

            // Check each user for matching credentials
            foreach ($users as $user) {
                if ($user['email'] === $email && password_verify($password, $user['password'])) {
                    $authenticatedUser = $user;
                    break;
                }
            }

            if ($authenticatedUser) {
                // Store user data in session
                $_SESSION['userID'] = $authenticatedUser['userID'];
                $_SESSION['userName'] = $authenticatedUser['firstName'] . ' ' . $authenticatedUser['lastName'];
                $_SESSION['userType'] = $authenticatedUser['userType'];
                $_SESSION['theme'] = $authenticatedUser['theme'];
                $_SESSION['lang'] = $authenticatedUser['language'] ?? 'en';
                
                // Debug output
                echo "Session data set:<br>";
                echo "UserID: " . $_SESSION['userId'] . "<br>";
                echo "UserName: " . $_SESSION['userName'] . "<br>";
                echo "UserType: " . $_SESSION['userType'] . "<br>";
                echo "Theme: " . $_SESSION['theme'] . "<br>";
                
                // Redirect to users management page
                header('Location: http://localhost/ecommerce/project/systemdevelopment/index.php?url=users');
                exit();
            } else {
                $this->loginView->render('Invalid email or password');
            }
        } else {
            $this->loginView->render();
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
        exit();
    }
}
