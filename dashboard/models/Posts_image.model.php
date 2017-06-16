<?php

class Posts_image extends Posts
{
	public static $table_name;
	public static $key_column = "post_id";
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."posts";
	}

	public static function get_image_ext($img_type){
			if(empty($img_type)) return false;
				switch($img_type){
					case "image/jpeg": return ".jpg";
					case "image/png": return ".png";
					case "image/gif": return ".gif";
					default: return false;
				}
	}

	public static function get_image_type($img_type){
		if(empty($img_type)) return false;
			$img_type = explode("/",$img_type);
			if($img_type[0] === "image"){
				return "image";
			}else{
				return false;
			}
	}

	public static function get_image_name($img_name){
		if(empty($img_name)) return false;
	
			$i_name = $img_name;
			for($i=0;$i<strlen($i_name);$i++){
				if($i_name[$i]== " "){
					$i_name = str_replace(" ","-",$i_name);
				}
				if($i_name[$i]== "_"){
					$i_name = str_replace("_","-",$i_name);
				}
				if($i_name[$i]== "|"){
					$i_name = str_replace("|","-",$i_name);
				}
				
			}
			
			/*
			$id = uniqid();
			$id2 = substr($id,9);
			*/
			
			$i_name = explode(".",$i_name);
			$name = $i_name[0] . "_" . date("dmyHis");
			return $name;
		}
		
	public static function get_image_name_library($img_name){
		if(empty($img_name)) return false;
	
			$i_name = $img_name;
			for($i=0;$i<strlen($i_name);$i++){
				if($i_name[$i]== " "){
					$i_name = str_replace(" ","-",$i_name);
				}
				if($i_name[$i]== "_"){
					$i_name = str_replace("_","-",$i_name);
				}
				if($i_name[$i]== "|"){
					$i_name = str_replace("|","-",$i_name);
				}
				
			}
			$i_name = explode(".",$i_name);
			$name = $i_name[0];
			//$name = explode("-",$name);
			//$name = $name[0];
			return $name;
		}
			
	public static function get_image_new_name($img_name,$img_ext){
		$img_name = self::get_image_name($img_name);
		$img_ext = self::get_image_ext($img_ext);
		$new_name = $img_name . $img_ext;
		return $new_name;
	}
			
	// Move upload image from form to destination
	public function insert_image($img_tmp_name,$img_name,$path=null){
		if($path === null){
			$image_dir = Config::get("image_dir");
		}else{
			$image_dir = Config::get($path);
		}
		
		$target_path = $image_dir . $img_name;
		move_uploaded_file($img_tmp_name,$target_path);
	}
	
	public static function image_set($id){
		$stmt = self::$_db->prepare("SELECT post_image FROM ".Config::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if($res['post_image'] == "none"){
			return false;
		}else{
			return true;
		}
	}
	
	public static function show_image($id,$width=400){
		$stmt = self::$_db->prepare("SELECT post_image FROM ".Config::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$alt= explode("_",$res['post_image']);
		$output = "<img src=".Config::get('image_dir').$res['post_image']." alt=".$alt[0]." title=".$alt[0]." width=".$width.">";
		echo $output;
	}
	
	public static function get_post_image_name($id){
		$stmt = self::$_db->prepare("SELECT post_image FROM ".Config::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['post_image'];
	}
	
	public static function delete_previous_image($post_image){
		if($post_image === "none"){
			return false;
		}
		$path = Config::get("path");
		$image_dir = Config::get("image_dir");
		if(@unlink($image_dir.$post_image)){
		}else{
			Alerts::get_alert("info",null,"Your last image is alredy deleted, but don't worry, your new image is successfully set.");
		}
	}
	
	
	
}


Posts_image::Init();
?>























