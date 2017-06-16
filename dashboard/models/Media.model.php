<?php

class Media extends Entity
{
	
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	


}





Media::Init();
?>



