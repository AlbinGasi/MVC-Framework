<?php

class Media_index extends Media
{
	
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	public static function get_gallery_rows_number(){
		$stmt = self::$_db->query("SELECT ".Config::get('table_prefix')."posts.post_id FROM ".Config::get('table_prefix')."posts INNER JOIN ".Config::get('table_prefix')."gallery on ".Config::get('table_prefix')."gallery.post_id=".Config::get('table_prefix')."posts.post_id");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$num = [];
		foreach($res as $gallery){
			$num[] .= $gallery['post_id'];
		}
		$num2 = array_unique($num);
		$num3 = count($num2);
		return $num3;
	}
	
	public static function get_posts_with_gallery($start,$limit){
		$stmt = self::$_db->query("SELECT ".Config::get('table_prefix')."posts.post_id FROM ".Config::get('table_prefix')."posts INNER JOIN ".Config::get('table_prefix')."gallery on ".Config::get('table_prefix')."gallery.post_id=".Config::get('table_prefix')."posts.post_id");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount() >= 1){
		$num = [];
		foreach($res as $gallery){
			$num[] .= $gallery['post_id'];
		}
		$num2 = array_unique($num);
		$post_id = "";
		foreach($num2 as $gallery2){
			$post_id .= $gallery2 . ",";
		}
		$post_id = trim($post_id,",");
		//return $post_id;

		$stmt2 = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."posts WHERE post_id in ($post_id) ORDER BY post_date DESC LIMIT {$start}, {$limit}");
		$res2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		return $res2;
		}else {
			Alerts::get_alert("info","There's no posts with gallery. You can easy add a new gallery by adding some of pictures in your new posts or you can edit existing post by adding pictures and your post will be here.");
		}
	}
	


}





Media_index::Init();
?>



