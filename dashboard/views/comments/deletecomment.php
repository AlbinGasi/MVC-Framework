<?php
$comment_id = (isset($_POST['commentId'])) ? trim(strip_tags($_POST['commentId'])) : null;
$commentAthor = (isset($_POST['commentAuthor'])) ? trim(strip_tags($_POST['commentAuthor'])) : null;

 if($comment_id == null || $commentAthor == null){
    Alerts::get_alert("danger","Error");
    return false;
 }

if(Admin::can_view_2()){
    if(Comments::deleteComment($comment_id)){
        Alerts::get_alert("info","Success","Successfully deleted a comment");
    }else{
         Alerts::get_alert("danger","Error");
    }
}else if(Users::is_loggedin()){
    $user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;
	$user = Users::get_by_id($user_id);

    if($commentAthor == $user->username){
        if(Comments::deleteComment($comment_id)){
            Alerts::get_alert("info","Success","Successfully deleted a comment");
        }else{
             Alerts::get_alert("danger","Error");
        }
    }

}
?>