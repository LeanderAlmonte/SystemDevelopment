<?php

namespace controllers;

use models\User;
use views\auth\Login;

require_once(dirname(__DIR__) . '/models/User.php');
require_once(dirname(__DIR__) . '/resources/views/auth/login.php');

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
                // Start session and store user data
                session_start();
                $_SESSION['user_id'] = $authenticatedUser['userId'];
                $_SESSION['user_name'] = $authenticatedUser['firstName'] . ' ' . $authenticatedUser['lastName'];
                $_SESSION['user_type'] = $authenticatedUser['userType'];
                $_SESSION['theme'] = $authenticatedUser['theme'];

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
        session_start();
        session_destroy();
        header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=auths/login');
        exit();
    }
}
