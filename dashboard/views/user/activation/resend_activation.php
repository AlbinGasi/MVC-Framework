<?php

$email = (!empty($_POST['email_resend'])) ? strip_tags(trim($_POST['email_resend'])) : "";


if(Validation_user::email_resend_validation($email)){
	$activation_code = Users_gen::get_data_by_email($email);
	Users_gen::send_activation_code($email,$activation_code);
	Alerts::get_alert("info","Success","Your activation code is sent to email.");
}else{
	Validation_user::get_error();
}

















?>