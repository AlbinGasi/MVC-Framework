<?php
$this->user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;
$usrname = (!empty($_POST['usrname'])) ? trim(strtolower($_POST['usrname'])) : "";
mb_internal_encoding('UTF-8');
$user_id = $this->user_id;
if(!empty($usrname)){
	$user3 = Users_gen::get_user_by_username($usrname);
	$user_id = $user3->user_id;
}

$user_gen = Users::get_by_id($user_id);
$email2 = $user_gen->email;
$username2 = $user_gen->username;

if(Users::is_loggedin()){

$first_name = (!empty($_POST['first_name'])) ? trim(strip_tags(mb_strtolower($_POST['first_name']))): "";
$last_name = (!empty($_POST['last_name'])) ? trim(strip_tags(mb_strtolower($_POST['last_name']))) : "";


$username = (!empty($_POST['username'])) ? trim(strip_tags(mb_strtolower($_POST['username']))) : "";

$d = (!empty($_POST['birth_d'])) ? trim(strip_tags($_POST['birth_d'])) : "";
$m = (!empty($_POST['birth_m'])) ? trim(strip_tags($_POST['birth_m'])) : "";
$y =(!empty($_POST['birth_y'])) ? trim(strip_tags($_POST['birth_y'])) : "";

$date = "";
if(Validation_user::validate_birth_date($d,$m,$y)){
	$date = $d . "." . $m . "." . $y;
}else{
	Validation_user::get_error();
	return false;
}

$user_gender = (!empty($_POST['gender'])) ? trim(strip_tags($_POST['gender'])) : "";
$home_address = (!empty($_POST['home_address'])) ? trim($_POST['home_address']) : "";
$email = (!empty($_POST['email'])) ? trim($_POST['email']) : "";
$user_status_name = (!empty($_POST['user_status'])) ? trim(strip_tags($_POST['user_status'])) : "";
$user_status = Users_status::get_status_number($user_status_name);
$phone_number = (!empty($_POST['phone_number'])) ? trim(strip_tags($_POST['phone_number'])) : "";


$phone_number2 = Users_gen::get_user_by_username($usrname);

if(!Validation_user::phone_number($phone_number,$phone_number2->phone_number)){
	Validation_user::get_error();
	return false;
}

if(!Validation_user::check_gender($user_gender)){
	Validation_user::get_error();
	return false;
}

if(Validation_user::user_edit($first_name,$last_name,$username,$username2,$email,$email2)){
	$edit_user = new Users;
	$edit_user->first_name = $first_name;
	$edit_user->last_name = $last_name;
	$edit_user->username = $username;
	$edit_user->email = $email;
	
	if(!empty($date)){
		$edit_user->born_date = $date;
	}
	
	$edit_user->user_gender = $user_gender;
	$edit_user->user_address = $home_address;
	
	$main_admin = Users::get_by_id($this->user_id);
	if($main_admin->user_status == 351 || $main_admin->user_status == 350){
		if(Users::is_admin2($this->user_id)){
			if($user_gen->user_status != 351){
				if($user_status == 351){
					Alerts::get_alert("danger","Main Administrator can be only one!");
					return false;
				}else{
					$edit_user->user_status = $user_status;
				}
			}
		}
	}
	$edit_user->phone_number = $phone_number;
	
	if($edit_user->update($user_id,$username2)){
		Alerts::get_alert("info","Success"," You succesfully updated profile");
		$get_user_username = Users::get_by_id($this->user_id);
		
		if($get_user_username->username == $username2){
			Users::setUserActivity($get_user_username->username, "Edited profil", $user_id,'profil');
		}else{
			Users::setUserActivity($get_user_username->username, "Edited profil: ".ucfirst($username2), $user_id,'adminpass',$username2);
		}
		
	}else{
		Alerts::get_alert("danger","Error");
	}
	
}else{
	Validation_user::get_error();
}



}










?>