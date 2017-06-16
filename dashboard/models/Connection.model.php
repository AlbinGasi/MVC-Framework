<?php

class Connection
{
	private static $_instance = null;
	
	public function __construct(){}

    public static function get_instance(){
        if(is_null(self::$_instance)){
			try{
				self::$_instance = new PDO("mysql:host=".Config::get('DB/host').";dbname=".Config::get('DB/db_name').";charset=utf8",Config::get('DB/user'),Config::get('DB/password'));
			}catch(PDOException $e){
				die("Eror---> " . $e->getMessage());
			}
        }
        return self::$_instance;
    }
}



?>