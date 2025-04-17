<?php

namespace controllers;

use models\User;

use views\user\ManageUsers;

require(dirname(__DIR__) . '/resources/views/user/manageUsers.php');
require(dirname(__DIR__) . '/models/User.php');

class UserController {

    private User $user;

    public function read() {

        $user = new User();
        $data = $user->read();

        $manageUsers = new ManageUsers();
        $manageUsers->render($data);

    }
}
