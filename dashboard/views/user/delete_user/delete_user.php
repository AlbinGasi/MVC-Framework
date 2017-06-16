<?php
$this->user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;

if(Users::is_admin2($this->user_id)){
$user_id = (!empty($_POST['user_id'])) ? $_POST['user_id'] : -22;

if(Users_gen::check_user_by_id($user_id)){
	$user = Users::get_by_id($user_id);
	if($user->user_status == 0){
		Alerts::get_alert("warning","Alredy deactivated."," This user is alredy deactivated.");
		return false;
	}else if($user->user_status == 351){
		Alerts::get_alert("warning","Administrator."," This user is the Owner.");
		return false;
	}
}

if(Users_gen::delete_user($user_id)){
	$get_user_username = Users::get_by_id($this->user_id);
	$get_user_victim = Users::get_by_id($user_id);
	Alerts::get_alert("info","Success","You deleted this user.");
	Users::setUserActivity($get_user_username->username, " Deleted user: ".ucfirst($get_user_victim->username),$user_id,"profil");
}else{
	Alerts::get_alert("danger","Error","There's some errors.");
}
}else{
	Alerts::get_alert("danger","Error","You don't have a privileges for this action.");
}



?>