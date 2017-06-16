<?php
$comment = (isset($_POST['comment'])) ? trim(strip_tags($_POST['comment'])) : "";
$postId = trim($_POST['postid']);
if(empty($comment)){
	Alerts::get_alert("danger","Error","You must enter a comment.");
	return false;
}

$checkPostStatus = Posts::get_by_id($postId);

if($checkPostStatus->comment_status == "closed"){
	Alerts::get_alert("danger","Error","Can't add a new comment for this post.");
	return false;
}

if(Users::is_loggedin()){
	$user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;
	$user = Users::get_by_id($user_id);
	
	$newComment = new Comments;
	$newComment->comment_author = $user->username;
	$newComment->comment = $comment;
	$newComment->comment_date2 = date('d.m.Y') . ' | ' . date('h:m:s');
	$newComment->post_id = $postId;
	if($newComment->insert()){
		Alerts::get_alert("info","Success","You have successfully added a new comment");
	}else{
		Alerts::get_alert("danger","Error","");
	}
	
}else{
	$username = trim(strip_tags($_POST['username']));
	$newComment = new Comments;
	$newComment->comment_author = $username;
	$newComment->comment = $comment;
	$newComment->post_id = $postId;
	if($newComment->insert()){
		Alerts::get_alert("info","Success","You have successfully added a new comment");
	}else{
		Alerts::get_alert("danger","Error","");
	}
}


?>