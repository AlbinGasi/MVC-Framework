<?php
namespace lib\models;
class Connection
{
	private static $_instance = null;

	public static function getInstance() {

		if(self::$_instance === null){
			try{
			self::$_instance = new \PDO('mysql:host='.Config::HOST.';dbname='.Config::DBNAME,Config::USER, Config::PASSWORD);
		} catch (PDOException $e) {
			die('Conntection failed: ' . $e->getMessage());
		}
			return self::$_instance;
		}
		return self::$_instance;
	}
}


?>