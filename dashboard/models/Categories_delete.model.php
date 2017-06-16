<?php

class Categories_delete extends Categories
{
	public static $table_name;
	public static $key_column = "category_id";
	private static $_db;

	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."categories";
	}
	
	public static function delete_category_ajax($id){
		$stmt = self::$_db->prepare("DELETE FROM ".Config::get('table_prefix')."categories WHERE category_id=?");
		$stmt->bindParam(1,$id);
		if($stmt->execute()){
			echo '<div class="alert alert-success">
                    <strong>Successful</strong> Category seccessfuly deleted.
              </div>';
		}else{
			echo '<div class="alert alert-danger">
                    <strong>Something is going wrong</strong> There is some error. Please contact your administrator.
              </div>';
		}
	} 
	
	
	
	
}


Categories_delete::Init();
?>
