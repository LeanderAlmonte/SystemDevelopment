<?php

namespace views\user;

class ManageUsers{


    public function render($data) {


        echo "<html>";

        echo "<body>";

        echo "<h1>Manage Users</h1>";
        echo "<table>";
        echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>User Type</th><th>Theme</th></tr>";
        foreach ($data as $user) {
            echo "<tr><td>{$user['firstName']}</td><td>{$user['lastName']}</td><td>{$user['email']}</td><td>{$user['userType']}</td><td>{$user['theme']}</td></tr>";
        }
        echo "</table>";
        echo "</body>";
        echo "</html>";
    }
}
