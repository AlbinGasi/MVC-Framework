<?php

class Media_gallery extends Media
{
	
	public static $table_name;
	public static $key_column = "gallery_id";
	
	private static $_db;
	
	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."gallery";
	}
	
	public static function get_library_all($page_number){
		$stmt = self::$_db->query("SELECT ".Config::get('table_prefix')."gallery.gallery_value FROM ".Config::get('table_prefix')."gallery ORDER BY ".Config::get('table_prefix')."gallery.gallery_id DESC");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public static function get_library($page_number){
		$item = Config::get("ADMIN/pagination_gallery_limit");
		$position = (($page_number-1) * $item);
		
		$stmt = self::$_db->query("SELECT ".Config::get('table_prefix')."gallery.gallery_value FROM ".Config::get('table_prefix')."gallery ORDER BY ".Config::get('table_prefix')."gallery.gallery_id DESC LIMIT {$position}, {$item}");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
}





Media_gallery::Init();
?>