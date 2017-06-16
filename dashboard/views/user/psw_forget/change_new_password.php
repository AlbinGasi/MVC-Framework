<?php

$user_id = (!empty($_POST['id'])) ? strip_tags(trim($_POST['id'])) : "";
$password = (!empty($_POST['password'])) ? trim($_POST['password']) : "";
$new_psw = (!empty($_POST['new_psw'])) ? trim($_POST['new_psw']) : "";

if(Validation_user::forget_password_change($password)){
	$get_psw_by_id = Users_gen::get_psw_by_id($user_id);
	$username = Users::get_by_id($user_id);
	if($new_psw == $get_psw_by_id){
		$user_update = new Users;
		$user_update->password = md5($password);
		$user_update->new_psw = uniqid();
		$user_update->update($user_id,$username->username);
		Alerts::get_alert("info","Success","Your password has been changed.");
	}else{
		Alerts::get_alert("danger","Error","Please contact the site administrator.");
	}
	
}else{
	Validation_user::get_error();
}





?>