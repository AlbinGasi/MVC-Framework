<?php

class Interface_x extends Entity
{
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	public static function get_img($imgName,$width=null,$height=null){		
		$mPath = Config::get("full_path") . "public/interface/img/";
		
		if($width == null && $height == null){
			$output = "<img src='".$mPath.$imgName."'>";
		}else{
			$output = "<img src='".$mPath.$imgName."' width='".$width."' height='".$height."'>";
		}
		return $output;
	}

	
}


Interface_x::Init();
?>



