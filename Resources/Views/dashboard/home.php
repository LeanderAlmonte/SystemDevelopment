<?php
require_once __DIR__ . '/../../../Core/db/dbconnectionmanager.php';

use database\DBConnectionManager;

$dbManager = new DBConnectionManager();
$db = $dbManager->getConnection();

$pageTitle = 'Home';
$activePage = 'home';
$content = ''; // Add your home page specific content here

require_once __DIR__ . '/../layouts/base.php';
?>
