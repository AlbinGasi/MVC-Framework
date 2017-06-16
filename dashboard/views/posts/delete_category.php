<?php

if(!isset($_POST['id'])){
	echo '<div class="alert alert-danger">
                    <strong>Sorry!</strong> Your request is invalid.
                </div>';
	return false;
}else if(!is_numeric($_POST['id'])){
	echo '<div class="alert alert-danger">
                    <strong>Sorry!</strong> Your request is invalid.
                </div>';
	return false;
}
$id = trim(strip_tags($_POST['id']));


if(Admin::can_view_2()){
Categories_delete::delete_category_ajax($id);
}else{
	Alerts::get_alert("danger","Error!","You can't delete this category.");
}



?>

