<?php

class Categories extends Entity
{
	public static $table_name;
	public static $key_column = "category_id";
	private static $_db;

	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."categories";
	}

	public static function get_category_for_post($id){
		$stmt = self::$_db->prepare("SELECT ".Config::get('table_prefix')."categories.category_name from ".Config::get('table_prefix')."categories JOIN ".Config::get('table_prefix')."post_category ON ".Config::get('table_prefix')."categories.category_id=".Config::get('table_prefix')."post_category.category_id WHERE ".Config::get('table_prefix')."post_category.post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public static function get_category_for_post2($id){
		$stmt = self::$_db->prepare("SELECT ".Config::get('table_prefix')."categories.category_name from ".Config::get('table_prefix')."categories JOIN ".Config::get('table_prefix')."post_category ON ".Config::get('table_prefix')."categories.category_id=".Config::get('table_prefix')."post_category.category_id WHERE ".Config::get('table_prefix')."post_category.post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$output = "";
		foreach ($res as $t => $v){
			$output .= $v['category_name'] . ",";
		}
		$output = trim($output,",");
		return $output;
	}

	// Get category id from category name
	public static function get_category_id($category_name){
		$stmt = self::$_db->prepare("SELECT category_id FROM ".Config::get('table_prefix')."categories WHERE category_name = :name");
		$stmt->bindParam(':name',$category_name);
		$stmt->execute();
		$id = $stmt->fetch(PDO::FETCH_ASSOC);
		return $id['category_id'];
	}
	
	// DELETE MULTIPLE CATEGORIES
	public static function delete_mulitple_categories($post_id){
		$stmt = self::$_db->prepare("DELETE FROM ".Config::get('table_prefix')."post_category WHERE post_id=?");
		$stmt->bindValue(1,$post_id);
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// MULTIPLE CATEGORIES This method puts id from post and categories to ".Config::get('table_prefix')."post_category table
	public static function insert_mulitple_categories($post_id,$category){
		//$output = "";
		foreach($category as $cat){
			$category_id = Categories::get_category_id($cat);
			//$output .= "({$post_id},{$category_id}),";
				$stmt = self::$_db->prepare("INSERT INTO ".Config::get('table_prefix')."post_category(post_id,category_id)VALUES(?,?)");
				$stmt->bindValue(1,$post_id);
				$stmt->bindValue(2,$category_id);
				$stmt->execute();
			}
			//$output = trim($output,",");
			//$stmt = self::$_db->query("INSERT INTO ".Config::get('table_prefix')."post_category(post_id,category_id)VALUES {$output}");
		
	}
	
	
	
	
	
	
	
}


Categories::Init();
?>
