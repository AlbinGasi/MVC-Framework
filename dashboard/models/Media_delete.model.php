<?php

class Media_delete extends Media
{
	
	private static $_db;

	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	
	public static function delete_images_gallery_from_base($img_name){
		$stmt = self::$_db->prepare("DELETE FROM ".Config::get('table_prefix')."gallery WHERE ".Config::get('table_prefix')."gallery.gallery_value=?");
		$stmt->bindValue(1,$img_name);
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	public static function delete_images_gallery($img_name){
		$images = $img_name;
		
		if($images == "none"){
			Alerts::get_alert("info","There is no selected images for delete.");
		}else{
			$images = explode("|",$images);
			$gallery_dir = Config::get("gallery_dir");
				
			$count = 0;
			$base_count = true;
			foreach($images as $image){
				if(@unlink($gallery_dir.$image)){
					$count++;
				}
				if(!self::delete_images_gallery_from_base($image)){
					$base_count = false;
				}
			}
			if($count > 0){
				Alerts::get_alert("info","{$count} images successfully deleted");
			}
			if($count == 0){
				if($base_count == true){
					Alerts::get_alert("info","Images successfully deleted from your base");
				}
			}
		}
	}
	
	


}





Media_delete::Init();
?>



