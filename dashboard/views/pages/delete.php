<?php


if(!isset($_POST['id'])){
	echo '<div class="alert alert-danger">
                    <strong id="msg_val">Error!</strong> Your request is invalid.
                </div>';
	return false;
}else if(!is_numeric($_POST['id'])){
	echo '<div class="alert alert-danger">
                    <strong id="msg_val">Error!</strong> Your request is invalid.
                </div>';
	return false;
}
$id = trim(strip_tags($_POST['id']));
$get_post_username = Posts_edit::get_by_id($id);
$get_user_username = Users::get_by_id(Admin::get_user_id());

if(Admin::can_view_2()){
Posts_delete::delete_post_ajax($id);
Comments::deleteCommentByPostId($id);
Users::setUserActivity($get_user_username->username, "Deleted a post",$id,'deleted');
}else{
	if($get_post_username->post_author == $get_user_username->username){
		Posts_delete::delete_post_ajax($id);
		Comments::deleteCommentByPostId($id);
		Users::setUserActivity($get_user_username->username, "Deleted a post",$id);
	}else{
		Alerts::get_alert("danger","Error!","You can't delete this post.");
	}
	
}










?>