<?php
if(session_id() == '') {
	session_start();
}
require_once 'config.php';
class EConfig
{
	private static $_db;

	// EConnection with database
	public static function Init(){
		self::$_db = EConnection::get_instance();
	}

	public static function get($path){
		$result = $GLOBALS['iwconfig'];
		$path = explode("/",$path);
		foreach($path as $part){
			if(isset($result[$part])){
				$result = $result[$part];
			}
		}
		return $result;
	}
}
EConfig::Init();

class EConnection
{
	private static $_instance = null;

	public function __construct(){}

	public static function get_instance(){
		if(is_null(self::$_instance)){
			try{
				self::$_instance = new PDO("mysql:host=".EConfig::get('DB/host').";dbname=".EConfig::get('DB/db_name').";charset=utf8",EConfig::get('DB/user'),EConfig::get('DB/password'));
			}catch(PDOException $e){
				die("Eror---> " . $e->getMessage());
			}
		}
		return self::$_instance;
	}
}

class Paginator
{
	private static $_db;
	private $_limit;
	private $_page;
	private $_query;
	private $_total;

	public static function Init(){
		self::$_db = EConnection::get_instance();
	}

	public function __construct($query){
		$this->_query = $query;

		$rs= self::$_db->query( $this->_query );
		$this->_total = $rs->rowCount();
		
		$this->_limit = EConfig::get("paginator_all_posts");
	}

	public function getData( $page = 1 ) {
		if($page < 1){
			$page = 1;
		}

		$this->_page    = $page;

		if ( $this->_limit == 'all' ) {
			$query = $this->_query;
		} else {
			$query = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
		}
		$rs = self::$_db->query( $query );

		if($rs->rowCount()<1){
			return "ERROR";
		}else{
		while ( $row = $rs->fetch(PDO::FETCH_ASSOC) ) {
			$results[]  = $row;
		}

		$result         = new stdClass();
		$result->page   = $this->_page;
		$result->limit  = $this->_limit;
		$result->total  = $this->_total;
		$result->data   = $results;
		return $result;
		}
		
	}

	public function createLinks( $links, $list_class ) {
		if ( $this->_limit == 'all' ) {
			return '';
		}

		$last       = ceil( $this->_total / $this->_limit );

		$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
		$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

		$html       = '<div class="' . $list_class . '">';
		$html       .= '<ul>';

		$class      = ( $this->_page == 1 ) ? "iw-disabled" : "";
		$html       .= '<li class="'.$class.'"><a href="?pg=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';

		if ( $start > 1 ) {
			$html   .= '<li><a href="?pg=1">1</a></li>';
			$html   .= '<li><span>...</span></li>';
		}

		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $this->_page == $i ) ? "iw-active" : "";
			$html   .= '<li class="' . $class . '"><a href="?pg=' . $i . '">' . $i . '</a></li>';
		}

		if ( $end < $last ) {
			$html   .= '<li><span>...</span></li>';
			$html   .= '<li><a href="?pg=' . $last . '">' . $last . '</a></li>';
		}

		$class      = ( $this->_page == $last ) ? "iw-disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="?pg=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';

		$html       .= '</ul>';
		$html       .= '</div>';

		return $html;
	}

}
Paginator::Init();





class PaginatorPostCategory
{
	private static $_db;
	private $_limit;
	private $_page;
	private $_query;
	private $_total;
	private $_category;

	public static function Init(){
		self::$_db = EConnection::get_instance();
	}

	public function __construct($category){
		$rs = $this->get_postByCategoryRowCount($category);
		$this->_total = $rs;
		$this->_limit = EConfig::get("paginator_all_posts_category");
	}
	
	public function get_postByCategoryRowCount($category){
		$stmt = self::$_db->prepare("SELECT * FROM ".EConfig::get('table_prefix')."categories WHERE category_name=?");
		$stmt->bindValue(1, $category);
		$stmt->execute();
		if ($stmt->rowCount() == 1){
			$category1 = $stmt->fetch(PDO::FETCH_ASSOC);
			$category_id = $category1['category_id'];
	
			$stmt2 = self::$_db->prepare("SELECT * FROM ".EConfig::get('table_prefix')."posts JOIN ".EConfig::get('table_prefix')."post_category ON ".EConfig::get('table_prefix')."posts.post_id=".EConfig::get('table_prefix')."post_category.post_id WHERE ".EConfig::get('table_prefix')."post_category.category_id=? and ".EConfig::get('table_prefix')."posts.post_status='publish' ORDER BY ".EConfig::get('table_prefix')."posts.post_date DESC");
			$stmt2->bindValue(1, $category_id);
			$stmt2->execute();
			$res = $stmt2->rowCount();
			return $res;
		}else{
			return 0;
		}
	}
	
	public function get_postByCategory($category,$query){
		$stmt = self::$_db->prepare("SELECT * FROM ".EConfig::get('table_prefix')."categories WHERE category_name=?");
		$stmt->bindValue(1, $category);
		$stmt->execute();
		if ($stmt->rowCount() == 1){
			$category1 = $stmt->fetch(PDO::FETCH_ASSOC);
			$category_id = $category1['category_id'];
	
			$stmt2 = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."posts JOIN ".EConfig::get('table_prefix')."post_category ON ".EConfig::get('table_prefix')."posts.post_id=".EConfig::get('table_prefix')."post_category.post_id WHERE ".EConfig::get('table_prefix')."post_category.category_id='{$category_id}' and ".EConfig::get('table_prefix')."posts.post_status='publish' ORDER BY ".EConfig::get('table_prefix')."posts.post_date DESC $query");
			if($stmt2->rowCount() > 0){
				$res = $stmt2->fetchAll(PDO::FETCH_ASSOC);
				return $res;
			}else{
				return "nopost";
			}
	
		}else{
			return "none";
		}
	}
	
	

	public function getData($page = 1,$category) {
		if($page < 1){
			$page = 1;
		}

		$this->_page = $page;

		if ( $this->_limit == 'all' ) {
			$query = "";
		} else {
			$query = " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
		}
		
		$all_post = $this->get_postByCategory($category, $query);
		foreach ($all_post as $row) {
			$results[]  = $row;
		}

			$result         = new stdClass();
			$result->page   = $this->_page;
			$result->limit  = $this->_limit;
			$result->total  = $this->_total;
			$result->data   = $results;
			return $result;
		

	}

	public function createLinks( $links, $list_class, $category ) {
		if ( $this->_limit == 'all' ) {
			return '';
		}

		$last       = ceil( $this->_total / $this->_limit );

		$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
		$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

		$html       = '<div class="' . $list_class . '">';
		$html       .= '<ul>';

		$class      = ( $this->_page == 1 ) ? "iw-disabled" : "";
		$html       .= '<li class="'.$class.'"><a href="'.EConfig::get('url_news').'?c='.$category.'&pg=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';

		if ( $start > 1 ) {
			$html   .= '<li><a href="'.EConfig::get('url_news').'?c='.$category.'&pg=1">1</a></li>';
			$html   .= '<li><span>...</span></li>';
		}

		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $this->_page == $i ) ? "iw-active" : "";
			$html   .= '<li class="' . $class . '"><a href="'.EConfig::get('url_news').'?c='.$category.'&pg=' . $i . '">' . $i . '</a></li>';
		}

		if ( $end < $last ) {
			$html   .= '<li><span>...</span></li>';
			$html   .= '<li><a href="'.EConfig::get('url_news').'?c='.$category.'&pg=' . $last . '">' . $last . '</a></li>';
		}

		$class      = ( $this->_page == $last ) ? "iw-disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="'.EConfig::get('url_news').'?c='.$category.'&pg=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';

		$html       .= '</ul>';
		$html       .= '</div>';

		return $html;
	}

}
PaginatorPostCategory::Init();


class PaginatorPostOfCategory
{
	private static $_db;
	private $_limit;
	private $_page;
	private $_query;
	private $_total;
	private $_category;

	public static function Init(){
		self::$_db = EConnection::get_instance();
	}

	public function __construct($category){
		$rs = $this->get_postOfCategoryRowCount($category);
		$this->_total = $rs;
		$this->_limit = EConfig::get("paginator_all_posts_of_categories");
	}

	public function get_postOfCategoryRowCount($category){
		$categoryUno = $category;
		$categoryUno = explode(",",$categoryUno);
		$category33 = "";
		foreach ($categoryUno as $cat){
			$category33 .= '\'' . $cat . '\'' . ",";
		}
		$category33 = trim($category33,",");
	
		$stmt = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."categories WHERE category_name2 in ({$category33})");
		if ($stmt->rowCount() > 0){
			$category1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$category_id = "";
			foreach ($category1 as $cat){
				$category_id .= $cat['category_id'] . ',';
			}
			$category_id = trim($category_id,",");
			$stmt2 = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."posts JOIN ".EConfig::get('table_prefix')."post_category ON ".EConfig::get('table_prefix')."posts.post_id=".EConfig::get('table_prefix')."post_category.post_id WHERE ".EConfig::get('table_prefix')."post_category.category_id in ({$category_id}) and ".EConfig::get('table_prefix')."posts.post_status='publish' ORDER BY ".EConfig::get('table_prefix')."posts.post_date DESC");
				$res = $stmt2->rowCount();
				return $res;
			}else{
				return 0;
			}

	}

	public function get_allPostsOfCategories($category,$query){
		$categoryUno = $category;
		$categoryUno = explode(",",$categoryUno);
		$category33 = "";
		foreach ($categoryUno as $cat){
			$category33 .= '\'' . $cat . '\'' . ",";
		}
		$category33 = trim($category33,",");
	
		$stmt = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."categories WHERE category_name2 in ({$category33})");
		if ($stmt->rowCount() > 0){
			$category1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$category_id = "";
			foreach ($category1 as $cat){
				$category_id .= $cat['category_id'] . ',';
			}
			$category_id = trim($category_id,",");
			$stmt2 = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."posts JOIN ".EConfig::get('table_prefix')."post_category ON ".EConfig::get('table_prefix')."posts.post_id=".EConfig::get('table_prefix')."post_category.post_id WHERE ".EConfig::get('table_prefix')."post_category.category_id in ({$category_id}) and ".EConfig::get('table_prefix')."posts.post_status='publish' ORDER BY ".EConfig::get('table_prefix')."posts.post_date DESC $query");
			if($stmt2->rowCount() > 0){
				$res = $stmt2->fetchAll(PDO::FETCH_ASSOC);
				return $res;
			}else{
				return "nopost";
			}
	
		}else{
			return "none";
		}
	}


	public function getData($page = 1,$category) {
		if($page < 1){
			$page = 1;
		}

		$this->_page = $page;

		if ( $this->_limit == 'all' ) {
			$query = "";
		} else {
			$query = " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
		}

		$all_post = $this->get_allPostsOfCategories($category, $query);
		foreach ($all_post as $row) {
			$results[]  = $row;
		}

		$result         = new stdClass();
		$result->page   = $this->_page;
		$result->limit  = $this->_limit;
		$result->total  = $this->_total;
		$result->data   = $results;
		return $result;
	}

	public function createLinks( $links, $list_class, $category ) {
		if ( $this->_limit == 'all' ) {
			return '';
		}

		$last       = ceil( $this->_total / $this->_limit );

		$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
		$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

		$html       = '<div class="' . $list_class . '">';
		$html       .= '<ul>';

		$class      = ( $this->_page == 1 ) ? "iw-disabled" : "";
		$html       .= '<li class="'.$class.'"><a href="?pg=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';

		if ( $start > 1 ) {
			$html   .= '<li><a href="?pg=1">1</a></li>';
			$html   .= '<li><span>...</span></li>';
		}

		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $this->_page == $i ) ? "iw-active" : "";
			$html   .= '<li class="' . $class . '"><a href="?pg=' . $i . '">' . $i . '</a></li>';
		}

		if ( $end < $last ) {
			$html   .= '<li><span>...</span></li>';
			$html   .= '<li><a href="?pg=' . $last . '">' . $last . '</a></li>';
		}

		$class      = ( $this->_page == $last ) ? "iw-disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="?pg=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';

		$html       .= '</ul>';
		$html       .= '</div>';

		return $html;
	}

}
PaginatorPostOfCategory::Init();










?>