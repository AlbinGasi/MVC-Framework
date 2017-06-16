<?php

class Users_status extends Users
{
	public static $table_name;
	public static $key_column = "id";
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."users_status";
	}

	
	public static function get_user_status($status){
		$stmt = self::$_db->prepare("SELECT status_name FROM ".Config::get('table_prefix')."user_status WHERE status_number=:status");
		$stmt->bindParam(":status",$status);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['status_name'];
	}
	
	public static function get_all_status(){
		$stmt = self::$_db->prepare("SELECT status_name FROM ".Config::get('table_prefix')."user_status");
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public static function get_status_number($status){
		$stmt = self::$_db->prepare("SELECT status_number FROM ".Config::get('table_prefix')."user_status WHERE status_name=:status");
		$stmt->bindParam(":status",$status);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['status_number'];
	}
	
	
	

	
}


Users_status::Init();
?>



