<?php

class Posts_all extends Entity
{
	public static $table_name;
	public static $key_column = "post_id";
	private static $_db;
	
	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."posts";
	}
		
	public static function comment_allowed($id){
		$post = Posts::get_by_id($id);
		if($post->comment_status == "open"){
			return true;
		}else{
			return false;
		}
	}
	
	
}





Posts_all::Init();
?>