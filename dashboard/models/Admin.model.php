<?php

class Admin extends Entity
{
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	public static function get_user_id(){
		$siteHASH = Config::get('hash_key');
		$user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
		return $user_id;
	}
	
	public static function get_users($status,$status2=null){
		if($status2 !== null){
			$stmt = self::$_db->prepare("SELECT * FROM ".Config::get('table_prefix')."users WHERE user_status in (:status, :status2)");
		}else{
			$stmt = self::$_db->prepare("SELECT * FROM ".Config::get('table_prefix')."users WHERE user_status=:status");
		}
		$stmt->bindParam(":status",$status);
		if($status2 !== null){
			$stmt->bindParam(":status2",$status2);
		}
		
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public static function can_view(){
		$siteHASH = Config::get('hash_key');
		$user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
	
		if(Users::is_admin2($user_id) || Users::is_moderator($user_id) || Users::is_writer($user_id)){
			return true;
		}else{
			return false;
		}
	}
	
		public static function can_view_2(){
		$siteHASH = Config::get('hash_key');
		$user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
		
		if(Users::is_admin2($user_id) || Users::is_moderator($user_id)){
			return true;
		}else{
			return false;
		}
	}
	
	public static function is_writer(){
		$siteHASH = Config::get('hash_key');
		$user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
		
		if(Users::is_writer($user_id)){
			return true;
		}else{
			return false;
		}
	}
	
	public static function is_mod(){
		$siteHASH = Config::get('hash_key');
		$user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
		
		if(Users::is_moderator($user_id)){
			return true;
		}else{
			return false;
		}
	}
	
	public static function admin_moderator_author($author){
		$siteHASH = Config::get('hash_key');
		$user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
		
		$loggedUser= Users::get_by_id(self::get_user_id());
		
		if(Users::is_admin2($user_id) || Users::is_moderator($user_id)){
			return true;
		}else if($loggedUser->username == $author){
			return true;
		}else{
			return false;
		}
	}
	

	
}


Admin::Init();
?>



