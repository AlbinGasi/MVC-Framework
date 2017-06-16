<?php
require_once '../class/Connection.class.php';
require_once '../class/Table.class.php';

$host = $_POST['host'];
$user = $_POST['user'];
$password = $_POST['password'];
$dbname = $_POST['dbname'];

$tblprefix = $_POST['tblprefix'];
$tbltype = $_POST['tbltype'];

$connection = new Connection ($host, $user, $password, $dbname);
$db = $connection->getConnection();

$tables = new Table ($tblprefix, $tbltype);
$query = $tables->getQuery();

if($db->query($query)){
	echo "<span id='spfinmsg'>It's done, one more step.</span>";
}else{
	echo "<span id='spfinmsg'>Error, check your database settings.</span>";
}







?>