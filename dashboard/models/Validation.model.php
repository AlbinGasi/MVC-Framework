<?php

class Validation
{
	private static $_db;
	
	private static $_errors = array();

	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	
	// SITE VALIDATION
		public static function params3_($params3){
			if($params3 !== null){
				Bootstrap::error("index");
				return true;
			}
		}
	
	// VALIDATION FOR POSTS
		public static function post_validation($title,$introduction,$content,$category,$post_type,$comment_status,$post_status,$post_author){
			if(empty($title)){
				self::$_errors['title'] = "Insert title.";
			}else if(strlen($title)<3){
				self::$_errors['title'] = "Title must have more than 5 character.";
			}
			
			
			if(empty($category)){
				self::$_errors['category'] = "Insert category.";
			}
			
			/*
			 if(empty($post_type)){
				self::$_errors['post_type'] = "Insert comment status.";
			}
				$check_post_type = Posts::post_type();
				if(in_array($post_type,$check_post_type)){
	
				}else{
					self::$_errors['post_type'] = "Insert valid post type.";
				}
				*/
			
			if(empty($comment_status)){
				self::$_errors['comment_status'] = "Insert comment status.";
			}
				$check_comment = Posts::comment_status();
				if(in_array($comment_status,$check_comment)){
					
				}else{
					self::$_errors['comment_status'] = "Insert valid comment status.";
				}
			
			
			if(empty($post_status)){
				self::$_errors['post_status'] = "Insert post_status.";
			}
				$check_post_status = Posts::post_status();
				if(in_array($post_status,$check_post_status)){
					
				}else{
					self::$_errors['post_status'] = "Insert valid post status.";
				}
			
			
			if(empty(self::$_errors)){return true;}else{return false;}
		}
	
	
	// ***************************
	
	
	
	// VALIDATION FOR POST IMAGE
		public static function post_image_validation($type,$size){
			$check_type = Posts_image::get_image_type($type);
			$check_size = $size;
			$check_ext = Posts_image::get_image_ext($type);
			
			if($check_type !== "image"){
				self::$_errors['imagetype'] = "Your file must be image.";
				return false;
			}
			
			if($check_ext !== ".jpg" && $check_ext !== ".png" && $check_ext !== ".gif"){
				self::$_errors['imageext'] = "Only <b>JPG, PNG and GIF</b> format are allowed.";
				return false;
			}
			
			if($check_size > 4000000){
				self::$_errors['imagesize'] = "Image can't be larger then 4MB.";
				return false;
			}
			
			if(empty(self::$_errors)){return true;}else{return false;}
			
		}
	
	
	// ***************************
	
	// VALIDATION for category
		public static function category_exists($category_name){
		$stmt = self::$_db->prepare("SELECT category_name FROM ".Config::get('table_prefix')."categories WHERE category_name = ?");
			$stmt->bindParam(1, $category_name);	
			$stmt->execute();
			if($stmt->rowCount() > 0 ){
				return true;
			}else{
				return false;
			}
	}

		public static function category_validate($category_name){
			if(empty($category_name)){
				self::$_errors['category_validate'] = "Insert category name.";
			}else if(strlen($category_name)<2){
				self::$_errors['category_validate'] = "Category must have more than 2 character.";
			}else if(self::category_exists($category_name)){
				self::$_errors['category_validate'] = "Category alredy exists.";
			}
			
			if(empty(self::$_errors)){return true;}else{return false;}
		}
	
	
	
	
	
	// ***************************
	
	public static function get_error(){
			foreach(self::$_errors as $error => $val){
				echo "<div style='margin-bottom:3px' class='alert alert-warning'>{$val}</div>";
			}
	}
	
}

Validation::Init();







?>