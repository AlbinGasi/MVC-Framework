<?php
if(!isset($_POST['actNumber'])){
	echo '<div class="alert alert-danger">
                    <strong>Sorry!</strong> Your request is invalid.
                </div>';
	return false;
}else if(!is_numeric($_POST['actNumber'])){
	echo '<div class="alert alert-danger">
                    <strong>Sorry!</strong> Your request is invalid.
                </div>';
	return false;
}
$actNumber = trim(strip_tags($_POST['actNumber']));


if(Admin::can_view_2()){
$userActivityNumber = $this->index->getUsersActivityNumber();

if($actNumber > $userActivityNumber){
	Alerts::get_alert("danger","Error!"," You have only: ".$userActivityNumber." activity.");
}else{
	if($this->index->deleteUsersActivity($actNumber)){
		Alerts::get_alert("info","Success!"," You have deleted: ".$actNumber . " activities.");
	}else{
		Alerts::get_alert("danger","Uuups!"," There some error.");
	}
}

}else{
	Alerts::get_alert("danger","Error!","You can't delete this category.");
}



?>

