<?php

class Comments extends Entity
{
	public static $table_name;
	public static $key_column = "comment_id";
	private static $_db;

	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."comments";
	}

    public static function get_all_comments(){
       $stmt = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."comments");
       $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $res;
    }
	
    public static function get_comments_rows_number(){
		$stmt = self::$_db->query("SELECT count(comment_id) FROM ".Config::get('table_prefix')."comments");
		$res = $stmt->fetchColumn();
		return $res;
	}

    public static function get_comment_by_post($post_id){
        $stmt = self::$_db->prepare("SELECT count(comment_id) FROM ".Config::get('table_prefix')."comments INNER JOIN ".Config::get('table_prefix')."posts on ".Config::get('table_prefix')."comments.post_id=".Config::get('table_prefix')."posts.post_id WHERE ".Config::get('table_prefix')."posts.post_id=:id");
		$stmt->bindValue(":id",$post_id);
		$stmt->execute();
		$res = $stmt->fetchColumn();
        return $res;
    }

    public static function deleteComment($id){
    	$stmt = self::$_db->prepare("DELETE FROM ".Config::get('table_prefix')."comments WHERE comment_id=?");
    	$stmt->bindParam(1,$id);
    	if($stmt->execute()){
    		return true;
    	}else{
    		return false;
    	}
    }
    public static function deleteCommentByPostId($post_id){
    	$stmt = self::$_db->prepare("DELETE FROM ".Config::get('table_prefix')."comments WHERE post_id=?");
    	$stmt->bindParam(1,$post_id);
    	if($stmt->execute()){
    		return true;
    	}else{
    		return false;
    	}
    }

	public static function show_last_comment($id){
		$stmt = self::$_db->prepare("SELECT * FROM ".Config::get('table_prefix')."comments INNER JOIN ".Config::get('table_prefix')."posts on ".Config::get('table_prefix')."comments.post_id=".Config::get('table_prefix')."posts.post_id WHERE ".Config::get('table_prefix')."posts.post_id=:id ORDER BY ".Config::get('table_prefix')."comments.comment_id DESC");
		$stmt->bindValue(":id",$id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$output = "";
		foreach($res as $comment){
		   $output .= '<div id="cm'.$comment['comment_id'].'" class="comment_sh">';
			if(Admin::can_view_2()){
				$output .= "<div class='editing' id='".$comment['comment_id']."'>".Interface_x::get_img("edit.png")."</div>";
				$output .= "<div class='deleting' id='".$comment['comment_id']."'>".Interface_x::get_img("delete.png")."</div>";
			}else{
				$user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;
				$users = Users::get_by_id($user_id);
				if($users->username == $comment['comment_author']){
				   $output .= "<div class='editing' id='".$comment['comment_id']."'>".Interface_x::get_img("edit.png")."</div>";
					$output .= "<div class='deleting' id='".$comment['comment_id']."'>".Interface_x::get_img("delete.png")."</div>";
				}

			}
			$output .= '<input type="hidden" id="cmtID" value="'.$comment['comment_id'].'">';
			$output .= '<span class="comment_author">'.ucfirst($comment['comment_author']).'</span>';
			$output .= '<span class="comment_author_date">'.Users_gen::convert_date($comment['comment_date']).'</span>';
			$output .= '<div class="comment_text">'.$comment['comment'].'</div>';
			$output .= '</div>';
		}

		return $output;


	}
	
	public static function show_comments_render($id){
		$path = Config::get("full_path");
		$output = "";
		
			$output .= '<div class="comments">';
			$output .= "<input type='hidden' id='pth_inscmt' value='".$path."'>";


		if(Users::is_loggedin()){
			$user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;

			$post = Posts::get_by_id($id);
			
			if(Posts_all::comment_allowed($id)){
				$user = Users::get_by_id($user_id);
				$output .= '<input type="text" class="comments_u" id="comment_uname" placeholder="Type username" value="'.$user->username.'" disabled>';
			}
		}else{
			if(Posts_all::comment_allowed($id)){
				$output .= '<input type="text" class="comments_u" id="comment_uname" placeholder="Type username">';
			}
		}
		if(Posts_all::comment_allowed($id)){
			$output .= '<textarea rows="4" cols="50" class="comments_text" id="comment_txttxt" placeholder="Enter a comment"></textarea>';
			$output .= '<div class="comment_btnbtn"><button id="btn_sub_comment" class="comment_btn">Comment</button></div>';
		}

		if(Posts_all::comment_allowed($id)){
			$output .= '<div class="hor_line"></div>';
		}
		$output .= '<div id="show_msg"></div>';
        $output .= '<div style="display:none;" id="showdlt_msg"></div>';
		return $output;
	}

	public static function show_comments_of_post($id){
		$stmt = self::$_db->prepare("SELECT * FROM ".Config::get('table_prefix')."comments INNER JOIN ".Config::get('table_prefix')."posts on ".Config::get('table_prefix')."comments.post_id=".Config::get('table_prefix')."posts.post_id WHERE ".Config::get('table_prefix')."posts.post_id=:id ORDER BY ".Config::get('table_prefix')."comments.comment_id DESC");
		$stmt->bindValue(":id",$id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$output = "";
        $output .= '<div class="modal fade" id="edit-comment" role="dialog">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Edit</h4>
					</div>
					<div class="modal-body">
						<div class="modal-body-edit-comment">


						</div>
                               <br>
					<div id="update-message">

					</div>

					</div>
					<div class="modal-footer">
					<button id="save-comment" type="button" class="btn btn-primary">Update</button>
					  <button id="close-comment" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>';




		$output .= self::show_comments_render($id);
        $output .= '<input type="hidden" id="pstid" value="'.$id.'">';
		$output .= "<div id='wrapper_comment'>";
		foreach($res as $comment){
			$output .= '<div id="cm'.$comment['comment_id'].'" class="comment_sh">';

			if(Admin::can_view_2()){
				$output .= "<div class='editing' id='".$comment['comment_id']."'>".Interface_x::get_img("edit.png")."</div>";
				$output .= "<div class='deleting' id='".$comment['comment_id']."'>".Interface_x::get_img("delete.png")."</div>";
			}else{
				$user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;
				$users = Users::get_by_id($user_id);
				if($users->username == $comment['comment_author']){
					$output .= "<div class='editing' id='".$comment['comment_id']."'>".Interface_x::get_img("edit.png")."</div>";
					$output .= "<div class='deleting' id='".$comment['comment_id']."'>".Interface_x::get_img("delete.png")."</div>";
				}

			}
			$output .= '<input type="hidden" id="cmtID" value="'.$comment['comment_id'].'">';
			$output .= '<span class="comment_author">'.ucfirst($comment['comment_author']).'</span>';
			$output .= '<span class="comment_author_date">'.Users_gen::convert_date($comment['comment_date']).'</span>';
			$output .= '<div class="comment_text">'.$comment['comment'].'</div>';
			$output .= '</div>';
		}

		$output .= "</div>";
        $output .= SiteFunc::get_script("public/js/custom/comment_function_post.js");
        $output .= "</div>";

		return $output;
	
	}
	

	
	
}


Comments::Init();
?>