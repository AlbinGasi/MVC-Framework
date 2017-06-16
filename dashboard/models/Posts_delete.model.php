<?php

class Posts_delete extends Posts
{
	public static $table_name;
	public static $key_column = "post_id";
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."posts";
	}
	
	public static function delete_post($id){
		$stmt = self::$_db->prepare("DELETE ".Config::get('table_prefix')."posts, ".Config::get('table_prefix')."post_category FROM ".Config::get('table_prefix')."posts INNER JOIN ".Config::get('table_prefix')."post_category WHERE ".Config::get('table_prefix')."posts.post_id=:id AND ".Config::get('table_prefix')."post_category.post_id=:id");
		$stmt->bindParam(":id",$id);
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	} 
	
	public static function delete_post_ajax($id){
		$stmt = self::$_db->prepare("DELETE ".Config::get('table_prefix')."posts, ".Config::get('table_prefix')."post_category FROM ".Config::get('table_prefix')."posts INNER JOIN ".Config::get('table_prefix')."post_category WHERE ".Config::get('table_prefix')."posts.post_id=:id AND ".Config::get('table_prefix')."post_category.post_id=:id");
		$stmt->bindParam(":id",$id);
		if($stmt->execute()){
			echo '<div class="alert alert-success">
                    <strong>Successful</strong> Your post has been deleted.
              </div>';
		}else{
			echo '<div class="alert alert-danger">
                    <strong>Something is going wrong</strong> There is some error. Please contact your administrator.
              </div>';
		}
	} 
	

	
}





Posts_delete::Init();
?>



