<?php

class Posts extends Entity
{
	public static $table_name;
	public static $key_column = "post_id";
	private static $_db;
	
	// Connection with database
	public static function Init(){
		self::$_db = Connection::get_instance();
		self::$table_name = Config::get('table_prefix')."posts";
	}

	// Post status
	public static function post_status(){
		$post_status = array("publish","draft");
		return $post_status;
	}
	
	public static function current_post_status($id){
		$stmt = self::$_db->prepare("SELECT post_status FROM ".Config::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['post_status'];
	}
	
	// Comment status
	public static function comment_status(){
		$comment_status = array("open","closed");
		return $comment_status;
	}
	
	public static function current_comment_status($id){
		$stmt = self::$_db->prepare("SELECT comment_status FROM ".Config::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['comment_status'];
	}
	
	// Post type
	public static function post_type(){
		$post_type = array("post","gallery");
		return $post_type;
	}
	
	public static function current_post_type($id){
		$stmt = self::$_db->prepare("SELECT post_type FROM ".Config::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['post_type'];
	}
	
	
	public static function get_post_author($id){
		$stmt = self::$_db->prepare("SELECT post_author FROM ".Config::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['post_author'];
	}
	
	public function get_post_date($id){
		$stmt = self::$_db->prepare("SELECT post_date FROM ".Config::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$res['post_date'];
		
		$_date = $res['post_date'];
		$_date = explode(" ",$_date);
		$date = $_date[0];
		$date = explode("-",$date);
		$d = $date[2];
		$m = $date[1];
		$y = $date[0];
		
		$complete_date = $d . "." . $m . "." . $y;
		
		return $complete_date;
	}
	
	public function get_post_time($id){
		$stmt = self::$_db->prepare("SELECT post_date FROM ".Config::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$res['post_date'];
		
		$_time = $res['post_date'];
		$_time = explode(" ",$_time);
		$time = $_time[1];
		$time = explode(":",$time);
		$h = $time[0];
		$m = $time[1];

		$complete_time = $h . ":" . $m;
		return $complete_time;

	}

    public static function if_more_than10($str,$length=null){
    	if($length==null){
	        $comm = "";
	        for($i=0;$i<strlen($str);$i++){
	            if($i<20){
	                $comm .= $str[$i];
	            }else if($i>20 && $i<25){
	                $comm .= ".";
	            }
	        }
	        return $comm;
    	}else{
    		$comm = "";
    		for($i=0;$i<strlen($str);$i++){
    			if($i<$length){
    				$comm .= $str[$i];
    			}else if($i>$length && $i<$length+5){
    				$comm .= ".";
    			}
    		}
    		return $comm;
    	}
    }
    
    public function get_postStatus(){
        $stmt = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."posts WHERE post_status='draft' ORDER BY post_date DESC");
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if($stmt->rowCount() < 1){
            return "";
        }else{
            return $res;
        }
    }

    public function get_postStatus2($type){
        $stmt = self::$_db->query("SELECT * FROM ".Config::get('table_prefix')."posts WHERE post_status='draft' and post_type='".$type."' ORDER BY post_date DESC");
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if($stmt->rowCount() < 1){
            return "";
        }else{
            return $res;
        }
    }
    
    public function setPostName($text){
    	$text = mb_strtolower($text, mb_detect_encoding($text));
    	$noviStr = $text;
    	
    	for($i=0;$i<strlen($noviStr);$i++){
    		if($i == " -"){
    			$noviStr = str_replace(" -","",$noviStr);
    		}
    		if($i == ": "){
    			$noviStr = str_replace(": ","-",$noviStr);
    		}
    		if($i == "ć"){
    			$noviStr = str_replace("ć","c",$noviStr);
    		}
    		if($i == "č"){
    			$noviStr = str_replace("č","c",$noviStr);
    		}
    		if($i == "đ"){
    			$noviStr = str_replace("đ","d",$noviStr);
    		}
    		if($i == "ž"){
    			$noviStr = str_replace("ž","z",$noviStr);
    		}
    		if($i == "š"){
    			$noviStr = str_replace("š","s",$noviStr);
    		}
    		if($i == " "){
    			$noviStr = str_replace(" ","-",$noviStr);
    		}
    		if($i == "\""){
    			$noviStr = str_replace("\"","-",$noviStr);
    		}
    		if($i == "'"){
    			$noviStr = str_replace("'","",$noviStr);
    		}
    		if($i == "/"){
    			$noviStr = str_replace("/","",$noviStr);
    		}
    		if($i == "("){
    			$noviStr = str_replace("(","",$noviStr);
    		}
    		if($i == ")"){
    			$noviStr = str_replace(")","",$noviStr);
    		}
    		if($i == ":"){
    			$noviStr = str_replace(":","-",$noviStr);
    		}
    		if($i == ","){
    			$noviStr = str_replace(",","",$noviStr);
    		}
    		if($i == "."){
    			$noviStr = str_replace(".","-",$noviStr);
    		}
    		if($i == ". "){
    			$noviStr = str_replace(". ","-",$noviStr);
    		}
    		if($i == "*"){
    			$noviStr = str_replace("*","-",$noviStr);
    		}
    		if($i == "?"){
    			$noviStr = str_replace("?","",$noviStr);
    		}
    	}
    
    	return $noviStr;
    }
   
    
    public function setPostNameEdit($text){
    	$text = mb_strtolower($text, mb_detect_encoding($text));    	
    	$noviStr = $text;
    	
    	for($i=0;$i<strlen($noviStr);$i++){
    		if($i == " -"){
    			$noviStr = str_replace(" -","",$noviStr);
    		}
    		if($i == ": "){
    			$noviStr = str_replace(": ","-",$noviStr);
    		}
    		if($i == "ć"){
    			$noviStr = str_replace("ć","c",$noviStr);
    		}
    		if($i == "č"){
    			$noviStr = str_replace("č","c",$noviStr);
    		}
    		if($i == "đ"){
    			$noviStr = str_replace("đ","d",$noviStr);
    		}
    		if($i == "ž"){
    			$noviStr = str_replace("ž","z",$noviStr);
    		}
    		if($i == "š"){
    			$noviStr = str_replace("š","s",$noviStr);
    		}
    		if($i == " "){
    			$noviStr = str_replace(" ","-",$noviStr);
    		}
    		if($i == "\""){
    			$noviStr = str_replace("\"","-",$noviStr);
    		}
    		if($i == "'"){
    			$noviStr = str_replace("'","",$noviStr);
    		}
    		if($i == "/"){
    			$noviStr = str_replace("/","",$noviStr);
    		}
    		if($i == "("){
    			$noviStr = str_replace("(","",$noviStr);
    		}
    		if($i == ")"){
    			$noviStr = str_replace(")","",$noviStr);
    		}
    		if($i == ":"){
    			$noviStr = str_replace(":","-",$noviStr);
    		}
    		if($i == ","){
    			$noviStr = str_replace(",","",$noviStr);
    		}
    		if($i == "."){
    			$noviStr = str_replace(".","-",$noviStr);
    		}
    		if($i == ". "){
    			$noviStr = str_replace(". ","-",$noviStr);
    		}
    		if($i == "*"){
    			$noviStr = str_replace("*","-",$noviStr);
    		}
    		if($i == "?"){
    			$noviStr = str_replace("?","",$noviStr);
    		}
    	}
    
    	return $noviStr;
    }
	
    public static function set_categoryName($text){
    	$text = mb_strtolower($text, mb_detect_encoding($text));
    	$noviStr = $text;
    	 
    	for($i=0;$i<strlen($noviStr);$i++){
    		if($i == " -"){
    			$noviStr = str_replace(" -","",$noviStr);
    		}
    		if($i == ": "){
    			$noviStr = str_replace(": ","-",$noviStr);
    		}
    		if($i == "ć"){
    			$noviStr = str_replace("ć","c",$noviStr);
    		}
    		if($i == "č"){
    			$noviStr = str_replace("č","c",$noviStr);
    		}
    		if($i == "đ"){
    			$noviStr = str_replace("đ","d",$noviStr);
    		}
    		if($i == "ž"){
    			$noviStr = str_replace("ž","z",$noviStr);
    		}
    		if($i == "š"){
    			$noviStr = str_replace("š","s",$noviStr);
    		}
    		if($i == " "){
    			$noviStr = str_replace(" ","-",$noviStr);
    		}
    		if($i == "\""){
    			$noviStr = str_replace("\"","-",$noviStr);
    		}
    		if($i == "\'"){
    			$noviStr = str_replace("\'","-",$noviStr);
    		}
    		if($i == "/"){
    			$noviStr = str_replace("/","",$noviStr);
    		}
    		if($i == "("){
    			$noviStr = str_replace("(","",$noviStr);
    		}
    		if($i == ")"){
    			$noviStr = str_replace(")","",$noviStr);
    		}
    		if($i == ":"){
    			$noviStr = str_replace(":","-",$noviStr);
    		}
    		if($i == ","){
    			$noviStr = str_replace(",","",$noviStr);
    		}
    		if($i == "."){
    			$noviStr = str_replace(".","-",$noviStr);
    		}
    		if($i == ". "){
    			$noviStr = str_replace(". ","-",$noviStr);
    		}
    		if($i == "*"){
    			$noviStr = str_replace("*","-",$noviStr);
    		}
    		if($i == "?"){
    			$noviStr = str_replace("?","",$noviStr);
    		}
    	}
    
    	return $noviStr;
    }
	
	
	
	
}





Posts::Init();
?>



