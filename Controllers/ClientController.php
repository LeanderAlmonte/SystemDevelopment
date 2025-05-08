<?php

namespace controllers;

use models\Client;
use views\client\ManageClients;

require(dirname(__DIR__) . '/resources/views/client/manageClient.php');
require(dirname(__DIR__) . '/models/Client.php');

class ClientController {

    private Client $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function read() {
        $data = $this->client->read();
        $manageClients = new ManageClients();
        $manageClients->render($data);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->client->create($_POST);
            if (isset($result['error'])) {
                $error = $result['error'];
                $this->showAddForm($error);
            } else {
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=clients');
                exit();
            }
        } else {
            $this->showAddForm();
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['clientId'] ?? null;
            if ($id) {
                $this->client->setClientID($id);
                $result = $this->client->delete();
                if (!$result) {
                    echo "<script>alert('Error: Failed to delete client');</script>";
                }
            }
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=clients');
            exit();
        }
    }

    private function showAddForm($error = null) {
        require(dirname(__DIR__) . '/resources/views/client/addClient.php');
        exit();
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['clientID'] ?? null;
            if ($id) {
                $this->client->setClientID($id);
                $this->client->setFirstName($_POST['firstName']);
                $this->client->setLastName($_POST['lastName']);
                $this->client->setEmail($_POST['email']);
                $this->client->setPhone($_POST['phone']);

                $result = $this->client->update();
                if (!$result) {
                    $this->showEditForm($id, 'Failed to update client');
                    return;
                }

                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=clients');
                exit();
            }
        } else {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $this->showEditForm($id);
            } else {
                header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=clients');
                exit();
            }
        }
    }

    private function showEditForm($id, $error = null) {
        $data = ['client' => $this->client->read($id)];
        require(dirname(__DIR__) . '/resources/views/client/editClient.php');
        $editClient = new \resources\views\client\EditClient();
        $editClient->render($data, $error);
        exit();
    }
}
