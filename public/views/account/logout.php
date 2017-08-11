<?php
require_once 'core/init.php';
use lib\models\Users;
use lib\models\Config;

if(Users::is_loggedin()){
	$siteHASH = Config::HASH_KEY;
	unset($_SESSION[$siteHASH]);
	header("Location: account/login");
}else{
	header("Location: index");
}
?>