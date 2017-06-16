<?php
class Config
{
	private static $_db;
	
	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
        public static function get($path){
           $result = $GLOBALS['iwconfig'];
           $path = explode("/",$path);
           foreach($path as $part){
                if(isset($result[$part])){
                    $result = $result[$part];
                }
           }
           return $result;
        }
}

Config::Init();
?>