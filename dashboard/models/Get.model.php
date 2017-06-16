<?php 
class Get extends Entity
{

	private static $_db;
	
	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	public function get_blog_json($number) {
		$tbl_prefix = Config::get('table_prefix');

		if($number == "all"){
			$stmt = self::$_db->prepare("SELECT * FROM {$tbl_prefix}posts ORDER by post_date DESC");
		}else if (is_numeric($number)){
			$stmt = self::$_db->prepare("SELECT * FROM {$tbl_prefix}posts ORDER by post_date DESC LIMIT {$number}");
		}
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$obj = json_encode($res);
		return $res;
	}
	
	public function get_blog_name_json($postName){
		$tbl_prefix = Config::get('table_prefix');
		$stmt = self::$_db->prepare("SELECT * FROM {$tbl_prefix}posts WHERE post_status='publish' and post_name=?");
		$stmt->bindValue(1, $postName);
		$stmt->execute();
		if($stmt->rowCount() == 1){
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			$obj = json_encode($res);
			return $res;
		}else{
			return 'none';
		}
	}

	public function get_page_json($pageName){
		$tbl_prefix = Config::get('table_prefix');
		$stmt = self::$_db->prepare("SELECT * FROM {$tbl_prefix}posts WHERE post_status='publish' and post_type='page' and post_name=?");
		$stmt->bindValue(1, $pageName);
		$stmt->execute();
		if($stmt->rowCount() == 1){
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			$obj = json_encode($res);
			return $res;
		}else{
			return 'none';
		}
	}
	

}


Get::Init();
?>