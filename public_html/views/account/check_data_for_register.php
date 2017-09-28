<?php
use lib\models\Users;

$users = new Users;

if(isset($_POST['username'])){
	$username = trim($_POST['username']);
	if($users->username_exists($username)){
		$res = ['messageUsername'=> 'Username already exist, use another'];
		echo json_encode(array($res));
	}else{
		$res = ['messageUsername'=> 'success'];
		echo json_encode(array($res));
	}
}

if(isset($_POST['email'])){
	$email = trim($_POST['email']);

	if($users->email_exists($email)){
		$res = ['messageEmail'=> 'Email already exist, use another'];
		echo json_encode(array($res));
	}else{
		$res = ['messageEmail'=> 'success'];
		echo json_encode(array($res));
	}
}


if(isset($_POST['register_user'])){
	$username = trim($_POST['usernameR']);
	$email = trim($_POST['emailR']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$born = trim($_POST['born']);
	$repassword = trim($_POST['repassword']);
	$password = trim($_POST['password']);

	$errors = true;

	
	if($username == ""){
		$errors = false;
	}else if(strlen($username)<2){
		$errors = false;
	}else if($users->username_exists($username)){
		$errors = false;
	}else{
		$errors = true;
	}

	if($email == ""){
		$errors = false;
	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errors = false;
	}else if($users->email_exists($email)){
		$errors = false;
	}else{
		$errors = true;
	}
	
	if($first_name == ""){
		$errors = false;
	}else if(strlen($first_name)<4){
		$errors = false;
	}else{
		$errors = true;
	}
	
	if($last_name == ""){
		$errors = false;
	}else if(strlen($last_name)<4){
		 $errors = false;
	}else{
		$errors = true;
	}
	
	if($born == ""){
		
	}else{
		
	}

	$checkPass1 = false;
	if($password == ""){
		$errors = false;
	}else if(strlen($password)<4){
		$errors = false;
	}else{
		$errors = true;
		$checkPass1 = true;
	}

	$checkPass2 = false;
	if($repassword == ""){
		$errors = false;
	}else if(strlen($repassword)<4){
		$errors = false;
	}else{
		$errors = true;
		$checkPass2 = true;
	}

	if($checkPass1 == true && $checkPass2 == true){
		if($password == $repassword){
			$errors = true;
		}else{
			$errors = false;
		}
	}

	$activation_code = $users->activation_code();
	if($errors){
		$password = md5($password);
		if($users->register_user($username,$first_name,$last_name,$born,$email,$password,$activation_code)){
			$users->send_activation_code($activation_code,$email);
			$out = ['messageRegister' => 'success','messageRegisterText' => 'Success! Now check your email for activation code.'];
			echo json_encode(array($out));
		}else{
			$out = ['messageRegister' => 'error','messageRegisterText' => 'There is some error!'];
			echo json_encode(array($out));
		}
	}else{
		$out = ['messageRegister' => 'error','messageRegisterText' => 'There is some error with your data!'];
		echo json_encode(array($out));
	}
}




?>