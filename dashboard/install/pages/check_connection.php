<?php
require_once '../class/Connection.class.php';

$host = $_POST['host'];
$user = $_POST['user'];
$password = $_POST['password'];
$dbname = $_POST['dbname'];

$connection = new Connection ($host, $user, $password, $dbname);

$connection->checkConnection();


?>