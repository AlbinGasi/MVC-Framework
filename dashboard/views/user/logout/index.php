<?php
if(Users::is_loggedin()){
	$siteHASH = Config::get('hash_key');
	unset($_SESSION[$siteHASH]);
	Alerts::get_alert("info","Successfuly logged out");
}
?>