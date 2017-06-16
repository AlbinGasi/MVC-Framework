<?php

class Pagination extends Posts
{
	public static $table_name;
	public static $key_column = "post_id";
	private static $_db;
	
	public static $start;
	public static $limit;
	public static $pg;
	public static $total;
	
	private static $_errors = array();
	
	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."posts";
	}
	
	public static function get_num_rows(){
		$stmt = self::$_db->query("SELECT count(*) FROM ".Config::get('table_prefix')."posts");
		$rows = $stmt->fetchColumn();
		return $rows;
	}
	
	public static function get_instance($pg,$pagLimit=null,$rows2=null){
		self::$start = 0;
		
		if($pagLimit != null){
			self::$limit = $pagLimit;
		}else{
			self::$limit = Config::get("ADMIN/pagination_limit");
		}
		
		if($rows2 != null){
			$rows = $rows2;
		}else{
			$rows = self::get_num_rows();
		}
		self::$total = ceil($rows/self::$limit);
		
		self::$pg = $pg;
		
		if(self::$pg === null){
			self::$pg = 1;
		}else if(self::$pg < 1){
			self::$_errors['badrequest'] = "Bad request";
		}else if(!is_numeric(self::$pg)){
			self::$_errors['badrequest'] = "Bad request";
		}else if(self::$pg > $rows){
			self::$_errors['badrequest'] = "Bad request";
		}
		
		self::$start = (self::$pg-1)*self::$limit;
		
		if(empty(self::$_errors)){
			return true;
		}else{
			return false;
		}
		

	}
		
	public static function show($path=null){
		
		if(!empty(self::$_errors)){
			Alerts::get_alert("warning","Invalid request");
			return false;	
		}
		
		$pagination = "";
		$pagination .= "<div style='width:200px;margin:0 auto;'>";
		$pagination .= "<nav aria-label='Page Navigation'>";
		$pagination .= "<ul class='pager'>";
		
		if(self::$pg > 1){
			if($path !=  null){
				$pagination .= "<li class='previous'><a href='".Config::get('path').$path.(self::$pg-1)."' aria-label='Next'><span aria-hidden='true'>&larr;</span>Newer</a></li>";
			}else{
				$pagination .= "<li class='previous'><a href='".Config::get('path').Config::get('ADMIN/pagination_path').(self::$pg-1)."' aria-label='Next'><span aria-hidden='true'>&larr;</span>Newer</a></li>";
			}
		}
		
		if(self::$pg != self::$total){
			if($path !=  null){
				$pagination .= "<li class='next'><a href='".Config::get('path').$path.(self::$pg+1)."' aria-label='Next'>Older<span aria-hidden='true'>&rarr;</span></a></li>";
			}else{
				$pagination .= "<li class='next'><a href='".Config::get('path').Config::get('ADMIN/pagination_path').(self::$pg+1)."' aria-label='Next'>Older<span aria-hidden='true'>&rarr;</span></a></li>";
			}
		}
		
		
		/*$pagination .= "<div class='text-center'>";
		$pagination .= "<nav aria-label='Page navigation'>";
		$pagination .= "<ul class='pagination'>";
		
		if(self::$pg > 1){
			$pagination .= "<li><a href='".Config::get('path')."posts/all/?pg=".(self::$pg-1)."' aria-label='Next'><span aria-hidden='true'>&laquo;</span></a></li>";
		}
		for($i=1;$i<=self::$total;$i++){
			if($i==self::$pg){
				$pagination .= "<li class='active'><a href='".Config::get('path')."posts/all/?pg=".$i."'>".$i."</a></li>";
			}else{
				$pagination .= "<li><a href='".Config::get('path')."posts/all/?pg=".$i."'>".$i."</a></li>";
			}
		}
		
		if(self::$pg != self::$total){
			$pagination .= "<li><a href='".Config::get('path')."posts/all/?pg=".(self::$pg+1)."' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
		}	
		$pagination .= "</ul>";*/
		
		$pagination .= "</nav>";
		$pagination .= "</div>";
		
		echo $pagination;
	}
	
}




Pagination::Init();
?>

