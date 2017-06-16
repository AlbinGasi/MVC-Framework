<?php

$first_name = (!empty($_POST['first_name'])) ? strip_tags(trim($_POST['first_name'])) : "";
$last_name = (!empty($_POST['last_name'])) ? strip_tags(trim($_POST['last_name'])) : "";
$username = (!empty($_POST['username'])) ? strip_tags(trim($_POST['username'])) : "";
$email = (!empty($_POST['email'])) ? strip_tags(trim($_POST['email'])) : "";
$password = (!empty($_POST['password'])) ? trim($_POST['password']) : "";


if(Validation_user::user_register_validion($first_name,$last_name,$username,$email,$password)){
	$user_activation_code = Users_gen::activation_code();
	
	$user = new Users;
	$user->first_name = strtolower($first_name);
	$user->last_name = strtolower($last_name);
	$user->username = strtolower($username);
	$user->email = $email;
	$user->password = md5($password);
	$user->user_activation = $user_activation_code;
	$user->insert();
	
	Alerts::get_alert("success","Succesful","Check your email for activation.");
	Users_gen::send_activation_code($email,$user_activation_code);
	
	
}else{
	Validation_user::get_error();
}





?>