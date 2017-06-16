<?php

class Posts_edit extends Posts
{
	public static $table_name;
	public static $key_column = "post_id";
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."posts";
	}
	
	public static function check_post_for_edtit($id){
		$stmt = self::$_db->prepare("SELECT post_id FROM ".Config::get('table_prefix')."posts WHERE post_id=:id");
		$stmt->bindParam(":id",$id);
		$stmt->execute();
		if($stmt->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	
}





Posts_edit::Init();
?>



