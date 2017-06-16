<?php
namespace lib\models;

class Index
{
	private static $_db;

	public static $table_name = '';
	public static $key_column = '';

	public static function Init() {
		self::$_db = Connection::getInstance();
	}

	public function message(){
		return 'Hello, I am ' . get_called_class() . ' class and you use ' . __method__ . ' method.';
	}

	
}

//Index::Init();
?>
