<?php

$email = (!empty($_POST['email'])) ? strip_tags(trim($_POST['email'])) : "";

if(Validation_user::email_resend_validation($email)){
	$user_id = Users_gen::get_user_id_from_email($email);
	$username = Users::get_by_id($user_id);
	
	$new_psw = uniqid();
	$user_update = new Users;
	$user_update->new_psw = $new_psw;
	$user_update->update($user_id,$username->username);
	
	Users_gen::send_new_password($email,$new_psw);
	Alerts::get_alert("info","Success","Check your email to finish changes.");
}else{
	Validation_user::get_error();
}


?>