<?php

class Posts_gallery extends Posts
{
	public static $table_name;
	public static $key_column = "post_id";
	private static $_db;
	
	
	public static $errors = array();
	public static $information = null;
	
	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."posts";
	}
	
	
	public static function gallery_set($id){
		$stmt = self::$_db->prepare("SELECT ".Config::get('table_prefix')."gallery.post_id FROM ".Config::get('table_prefix')."gallery INNER JOIN ".Config::get('table_prefix')."posts ON ".Config::get('table_prefix')."gallery.post_id=".Config::get('table_prefix')."posts.post_id WHERE ".Config::get('table_prefix')."posts.post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		if($stmt->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	public static function get_gallery_image_name($id){
		$stmt = self::$_db->prepare("SELECT ".Config::get('table_prefix')."gallery.gallery_value FROM ".Config::get('table_prefix')."gallery INNER JOIN ".Config::get('table_prefix')."posts ON ".Config::get('table_prefix')."gallery.post_id=".Config::get('table_prefix')."posts.post_id WHERE ".Config::get('table_prefix')."posts.post_id=? ORDER BY ".Config::get('table_prefix')."gallery.gallery_id DESC;");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public function create_post_gallery($id=null){
		$max_file_size = 4000000;
		$valid_formats = array("jpg","png","gif","jpeg");
		$count = 0;
		$post_gallery_class = new Posts_image;
		$media_galery = new Media_gallery;
		
		if(!empty($_FILES['gallery']['name'])){
			foreach($_FILES['gallery']['name'] as $g => $name){
				$img_new_name = Posts_image::get_image_new_name($name,$_FILES['gallery']['type'][$g]);

				if($_FILES['gallery']['error'][$g] == 4){continue;}
			
				if($_FILES['gallery']['error'][$g] == 0){
					if($_FILES['gallery']['size'][$g] > $max_file_size){
						self::$errors[] = "$name is too large!";
						continue;
					}else if(!in_array(pathinfo($name,PATHINFO_EXTENSION),$valid_formats)){
						self::$errors[] = "$name is not valid format!";
						continue;
					}else{
						$post_gallery_class->insert_image($_FILES['gallery']['tmp_name'][$g],$img_new_name,"gallery_dir");
						$count++;
						$media_galery->gallery_value = $img_new_name;
						if($id==null){
							$media_galery->post_id = Posts_insert::last_post_id();
						}else{
							$media_galery->post_id = $id;
						}
						$media_galery->insert();
					}
				}
			}
			self::$information = Alerts::get_alert("info",$count,"images in gallery uploaded","return");
		}else{
			self::$information = Alerts::get_alert("info","Information ","You don't select new image for your gallery","return");
		}
	}
	
	
	public function get_error_gallery(){
		foreach(self::$errors as $error => $val){
			echo "<div style='margin-bottom:3px' class='alert alert-warning'>{$val}</div>";
		}
	}
	
	public function get_information(){
		if(self::$information !== null){
			echo self::$information;
		}
	}

	
	
	
	
}


Posts_gallery::Init();
?>








	



















