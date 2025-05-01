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
        $data = $this->user->read();
        $manageUsers = new ManageUsers();
        $manageUsers->render($data);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->user->create($_POST);
            if (isset($result['error'])) {
                $error = $result['error'];
                $this->showAddForm($error);
            } else {
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=users');
                exit();
            }
        } else {
            $this->showAddForm();
        }
    }

    public function delete() {
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
        require(dirname(__DIR__) . '/resources/views/user/addUser.php');
        exit();
    }
}
