<?php
$this->user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;

if(Users::is_admin2($this->user_id)){
	$user_id = trim(strip_tags($_POST['userid']));
	$username = trim(strip_tags($_POST['userName']));
	
	$password1 = trim(strip_tags($_POST['password1']));
	$password2 = trim(strip_tags($_POST['password2']));
	
	
	if(Validation_user::change_psw($password1,$password2)){
		$change_psw = new Users;
		$change_psw->password = md5($password1);
		$get_user_username = Users::get_by_id($this->user_id);
	
		if($change_psw->update($user_id,$username)){
			Alerts::get_alert("info","Success"," You succesfully updated password");
			
			if($get_user_username->username == $username){
				Users::setUserActivity($get_user_username->username, "Changed a password", $user_id,'profil');
			}else{
				Users::setUserActivity($get_user_username->username, "Is changed a password for: ".ucfirst($username), $user_id,"adminpass",$username);
			}

		}else{
			Alerts::get_alert("danger","Error!");
		}
	}else{
		Validation_user::get_error();
	}
}else{
		Alerts::get_alert("danger","Error!","The Problem with authorization.");
	}

	
	











?>