<?php

namespace controllers;

use models\Client;
use views\client\ManageClients;
use resources\views\client\EditClient;

require(dirname(__DIR__) . '/resources/views/client/manageClient.php');
require(dirname(__DIR__) . '/resources/views/client/editClient.php');
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
                $result = $this->client->delete($id);
                if (isset($result['error'])) {
                    echo "<script>alert('Error: " . $result['error'] . "');</script>";
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
            $result = $this->client->update($_POST);
            if (isset($result['error'])) {
                $this->showEditForm($_POST['clientID'], $result['error']);
                return;
            }
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=clients');
            exit();
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
        $client = $this->client->read($id);
        if (!$client) {
            header('Location: /ecommerce/Project/SystemDevelopment/index.php?url=clients');
            exit();
        }
        $data = ['client' => $client];
        $editClient = new EditClient();
        $editClient->render($data, $error);
        exit();
    }
}
