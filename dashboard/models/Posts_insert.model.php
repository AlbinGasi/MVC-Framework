<?php

class Posts_insert extends Posts
{
	public static $table_name;
	public static $key_column = "post_id";
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."posts";
	}

	// Convert categories from array to string
	public static function implode_categories_name($category){
		$output = "";
		foreach($category as $cat){
			$output .= strip_tags($cat). ",";
		}
		$output = trim($output,",");
		return $output;
	}
	
	public static function change_post_date($post_id,$post_date){
		$stmt = self::$_db->query("UPDATE ".Config::get('table_prefix')."posts SET post_date='$post_date' WHERE post_id='$post_id'");
	}
	public static function change_post_date2($post_id,$post_date){
		$stmt = self::$_db->query("UPDATE ".Config::get('table_prefix')."posts SET post_date2='$post_date' WHERE post_id='$post_id'");
	}
	
	// Get last id from table ".Config::get('table_prefix')."post
	public static function last_post_id(){
		$dbname = Config::get("DB/db_name");
		$stmt = self::$_db->query("SELECT auto_increment FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '".Config::get('table_prefix')."posts'");
		$id = $stmt->fetch(PDO::FETCH_ASSOC);
		return $id['auto_increment'];
	}
	
	public static function last_post_id2(){
		$stmt = self::$_db->query("SELECT max(post_id) FROM ".Config::get('table_prefix')."posts");
		$id = $stmt->fetch(PDO::FETCH_ASSOC);
		return $id['max(post_id)'];
	}
	
	public static function get_postDate($id){
		$stmt = self::$_db->query("SELECT post_date2 FROM ".Config::get('table_prefix')."posts WHERE post_id='{$id}'");
		$id = $stmt->fetch(PDO::FETCH_ASSOC);
		return $id['post_date2'];
	}

	
	public function insert_post($post_title,$post_name,$post_introduction,$post_image,$post_content,$post_category,$post_type,$comment_status,$post_status,$post_author,$post_category2){
		$cdate = date("d.m.Y H:i");
		$stmt = self::$_db->prepare("INSERT INTO ".Config::get('table_prefix')."posts(post_title,post_introduction,post_image,post_content,post_category,post_author,post_status,post_type,comment_status,post_name,post_date2) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bindValue(1, $post_title);
		$stmt->bindValue(2, $post_introduction);
		$stmt->bindValue(3, $post_image);
		$stmt->bindValue(4, $post_content);
		$stmt->bindValue(5, $post_category);
		$stmt->bindValue(6, $post_author);
		$stmt->bindValue(7, $post_status);
		$stmt->bindValue(8, $post_type);
		$stmt->bindValue(9, $comment_status);
		$stmt->bindValue(10, $post_name);
		$stmt->bindValue(11, $cdate);
		$stmt->execute();
		$last_id = self::$_db->lastInsertId();
		$post_date = self::get_postDate($last_id);
		
		foreach($post_category2 as $cat){
			$category_id = Categories::get_category_id($cat);
			$stmt2 = self::$_db->prepare("INSERT INTO ".Config::get('table_prefix')."post_category(post_id,category_id)VALUES(?,?)");
			 $stmt2->bindValue(1,$last_id);
			 $stmt2->bindValue(2,$category_id);
			 $stmt2->execute();
		}

		if($post_type == 'post'){
			$pname2 = $post_name . "-" . $last_id;
		}else{
			$pname2 = $post_name;
		}
		
		
		$stmt3 = self::$_db->query("UPDATE ".Config::get('table_prefix')."posts SET post_name='$pname2' WHERE post_id='$last_id'");
		$stmt4 = self::$_db->query("UPDATE ".Config::get('table_prefix')."posts SET post_date2='$post_date' WHERE post_id='$last_id'");
		
		
		
		
	}
	

	
	
	
	
	
}


Posts_insert::Init();
?>