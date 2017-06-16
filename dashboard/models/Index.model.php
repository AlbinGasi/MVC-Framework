<?php 
class Index extends Entity
{
	public static $table_name = "";
	public static $key_column = "";
	private static $_db;
	
	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	public function deleteUsersActivity($limit){
		if($limit < 1){
			return false;
		}
		
		$stmt = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."user_activity LIMIT {$limit}");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$id = "";
		foreach ($res as $k => $v){
			$id .= $v['activity_id'] . ",";
		}
		$id = trim($id,",");

		$stmt2 = self::$_db->query("DELETE FROM ".Config::get('table_prefix')."user_activity WHERE activity_id in({$id})");
		if($stmt2){
			return true;
		}else{
			return false;
		}
		
		
		
	}
	
	public static function getUsersActivityNumber(){
		$stmt = self::$_db->query("SELECT count(activity_id) FROM ".Config::get('table_prefix')."user_activity");
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['count(activity_id)'];
	}
	
	
	public static function get_news_number(){
		$stmt = self::$_db->query("SELECT count(post_id) FROM ".Config::get('table_prefix')."posts");
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['count(post_id)'];
	}
	
	public function getUserActivity($qun=null){
		if($qun == "all"){
			$stmt = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."user_activity ORDER BY activity_id DESC");
		}else{
			$stmt = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."user_activity ORDER BY activity_id DESC  LIMIT 10");
		}
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public function getUserActivity_load($page_number){
		$item = Config::get("ADMIN/pagination_useractivity_limit");
		$position = (($page_number-1) * $item);
		
		$stmt = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."user_activity ORDER BY activity_id DESC  LIMIT {$position}, {$item}");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public static function get_categories_number(){
		$stmt = self::$_db->query("SELECT count(category_id) FROM ".Config::get('table_prefix')."categories");
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['count(category_id)'];
	}
	
	public static function get_number_of_posts_with_gallery(){
		$stmt = self::$_db->query("SELECT ".Config::get('table_prefix')."posts.post_id FROM ".Config::get('table_prefix')."posts INNER JOIN ".Config::get('table_prefix')."gallery on ".Config::get('table_prefix')."gallery.post_id=".Config::get('table_prefix')."posts.post_id;");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//return $res;
		$num = [];
		foreach($res as $gallery){
			$num[] .= $gallery['post_id'];
		}

		$num2 = array_unique($num);
		$num3 = count($num2);
		return $num3;
	}
	
	public static function get_users_number(){
		$stmt = self::$_db->query("SELECT count(user_id) FROM ".Config::get('table_prefix')."users");
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['count(user_id)'];
	}
	
	public function lastRegUsers(){
		$stmt = self::$_db->query("SELECT username, email, first_name, last_name FROM ".Config::get('table_prefix')."users ORDER BY user_id DESC LIMIT 5");
		$res = $stmt->fetchALL(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public function get_posts_with_gallery2(){
		$stmt = self::$_db->query("SELECT ".Config::get('table_prefix')."posts.post_id FROM ".Config::get('table_prefix')."posts INNER JOIN ".Config::get('table_prefix')."gallery on ".Config::get('table_prefix')."gallery.post_id=".Config::get('table_prefix')."posts.post_id");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		if($stmt->rowCount() >= 1){
			$num = [];
			foreach($res as $gallery){
				$num[] .= $gallery['post_id'];
			}
			$num2 = array_unique($num);
			$post_id = "";
			foreach($num2 as $gallery2){
				$post_id .= $gallery2 . ",";
			}
			$post_id = trim($post_id,",");
			//return $post_id;
	
			$stmt2 = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."posts WHERE post_id in ($post_id) ORDER BY post_id DESC LIMIT 5");
			$res2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
			return $res2;
		}else {
			return "none";
		}
	}
	
	public function getLatestComments(){
		$stmt = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."comments ORDER BY comment_id DESC LIMIT 5");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
}
Index::Init();





?>