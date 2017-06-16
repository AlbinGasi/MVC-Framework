<?php
//$comment_id = (isset($_POST['commentId'])) ? trim(strip_tags($_POST['commentId'])) : null;
//$commentAthor = (isset($_POST['commentAuthor'])) ? trim(strip_tags($_POST['commentAuthor'])) : null;


if(isset($_POST['showEditComment'])){
    $comment_id = $_POST['showEditComment'];

    $comment = Comments::get_by_id($comment_id);
    echo "<input type='hidden' id='cmtID' value='".$comment->comment_id."'>";
    echo "<input type='hidden' id='commentAuthor2' value='".$comment->comment_author."'>";
    echo '<textarea rows="4" cols="20" class="form-control" id="editComment" placeholder="Enter a comment">'.$comment->comment.'</textarea>';

}else{

       $comment_id = trim(strip_tags($_POST['cmtID']));
       $comment = trim(strip_tags($_POST['editComment']));
       $commentAuthor = trim(strip_tags($_POST['commentAuthor2']));
            if(empty($comment)){
                 Alerts::get_alert("danger","Error", "Comment can't be empty");
                return false;
            }


        if(Admin::can_view_2()){
            $editComment = new Comments;
            $editComment->comment = $comment;
            if($editComment->update($comment_id)){
                Alerts::get_alert("info","Success","Comment is successfully updated.");
            }else{
                 Alerts::get_alert("danger","Error");
            }
        }else if(Users::is_loggedin()){
             $user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;
             $user = Users::get_by_id($user_id);
             if($user->username == $commentAuthor){
               $editComment = new Comments;
               $editComment->comment = $comment;
               if($editComment->update($comment_id)){
                    Alerts::get_alert("info","Success","Comment is successfully updated.");
                }else{
                     Alerts::get_alert("danger","Error");
                }
             }
        }
  }
?>