<?php
 if(Admin::can_view_2()){
 	if(isset($_POST['duk'])){
 		$names = $_POST['names'];
 		Media_delete::delete_images_gallery($names);
 		Users::setUserActivity("administration", "Deleted some pictures from library","none","library");
 		return false;
 	}
 	
	 if(isset($_POST['names'])){
	 	$id = trim(strip_tags($_POST['postID']));
	 	$get_post_username = Posts_edit::get_by_id($id);
	 	$get_user_username = Users::get_by_id(Admin::get_user_id());
		$names = $_POST['names'];
		Media_delete::delete_images_gallery($names);
		
		Users::setUserActivity($get_user_username->username, "Deleted a gallery photos",$id);
	}else{
		Alerts::get_alert("danger","Your request is invalid.");
	}
 }else{
 	if(isset($_POST['names'])){
 		$id = trim(strip_tags($_POST['postID']));
 		$get_post_username = Posts_edit::get_by_id($id);
 		$get_user_username = Users::get_by_id(Admin::get_user_id());
 		$names = $_POST['names'];
 		
 		if($get_post_username->post_author == $get_user_username->username){
 			Media_delete::delete_images_gallery($names);
 			Users::setUserActivity($get_user_username->username, "Deleted a gallery photos",$id);
 		}else{
 			Alerts::get_alert("danger","You don't have a permission.");
 		}
 	}else{
 		Alerts::get_alert("danger","Your request is invalid.");
 	}
 	
 }
 


?>
