<?php

class Posts_view extends Posts
{
	public static $table_name;
	public static $key_column = "post_id";
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."posts";
	}
	
	public static function last_post_view_admin(){
		$stmt = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."posts ORDER BY post_id DESC LIMIT 1");
		$obj = $stmt->fetchObject(__class__);
		return $obj;
	}

	
}





Posts_view::Init();
?>



