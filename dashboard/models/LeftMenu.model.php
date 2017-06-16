<?php

class LeftMenu
{
	private static $_db;

	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
    
	public static function show_active_nav(){
		$g = Config::get("ADMIN/controller_get_name");
		if(isset($_GET[$g])){
			$url_name = $_GET[$g];
			$url_name = explode("/",$url_name);
			if(!empty($url_name[0])){
				return $url_name[0];
			}else{
				return "none";
			}
		}
	}
	
	public static function show_active_nav_part(){
		$g = Config::get("ADMIN/controller_get_name");
		if(isset($_GET[$g])){
			$url_name = $_GET[$g];
			$url_name = explode("/",$url_name);
			
			if(!empty($url_name[1])){
				return $url_name[1];
			}else{
				return "none";
			}
		}
	}
	
	
	
}

LeftMenu::Init();
?>