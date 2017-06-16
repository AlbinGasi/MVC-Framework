<?php


$username = (!empty($_POST['username'])) ? strtolower($_POST['username']) : "";
$password = (!empty($_POST['password'])) ? md5($_POST['password']) : "";


Users::user_login($username, $password);




?>