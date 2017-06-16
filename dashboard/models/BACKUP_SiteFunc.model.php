<?php

class SiteFunc
{
	public static function get_path(){
		$path = Config::get("path");
        $link = "<base href='".$path."'>";
        echo $link;
	}
	
	public static function get_script($link=null,$tag_text=null){
		if($link==null){
			$output = "<script>".$tag_text."</script>";
		}else if($tag_text == null){
			$output = "<script src='{$link}'></script>";
		}else if($link != null && $tag_text != null){
			$output = "<script src='{$link}'>".$tag_text."</script>";
		}
		echo $output;
	}
	public static function get_style($link){
		$output = "<link href='{$link}' rel='stylesheet' type='text/css'>";
		echo $output;
	}
	
	public static function admin_script(){
		self::get_style("public/css/bootstrap.min.css");
		self::get_style("public/css/custom/layout.css");
		self::get_style("public/css/bootstrap.css");
		self::get_style("public/css/sb-admin.css");
		self::get_style("public/font-awesome/css/font-awesome.min.css");
		self::get_script("public/js/tinymce/tinymce.min.js");
		self::get_script("public/js/jquery.js");
		self::get_script("","tinymce.init({ selector:'textarea' })");
	}
	
	public static function footer_script(){
		self::get_script("public/js/jquery.js");
		self::get_script("public/js/bootstrap.min.js");
		
	}
	
	public static function rend_header_top_level(){
		$output = "";
		$output .= 
		"
			<!DOCTYPE html>
				<html lang='en'>
				<head>
					<meta charset='utf-8'>
					<meta http-equiv='X-UA-Compatible' content='IE=edge'>
					<meta name='viewport' content='width=device-width, initial-scale=1'>
					<meta name='description' content=''>
					<meta name='author' content=''>
		";
		echo $output;
	}
	
	public static function rend_header($title){
		self::rend_header_top_level();
		$output = "";
		$output .= 
			self::get_path().
			"
				<title>{$title}</title>
				".self::admin_script()."
				</head>
			";
		echo $output;
	}
	
	public static function rend_page_heading($name_of_page,$nav){
		$output = "";
		$output .= 
		"
			<div id='page-wrapper'>
            <div class='container-fluid'>
			<div class='row'>
				<div class='col-lg-12'>
					<h1 class='page-header'>{$name_of_page}<small></small>
                        </h1>
                        <ol class='breadcrumb'>
                            <li>
                                <i class='fa fa-dashboard'></i>  <a href='index'>Dashboard</a>
                            </li>";
								$output .=  "{$nav}";
							  $output .="
                            </li> 
                        </ol>
                    </div>
			</div>
		";
		echo $output;
	}

	public static function rend_content_start($content_start=null){
		if($content_start==null){
			$output = "";
		}else{
			$output = "<div class='row'><div class='col-lg-{$content_start}'>";
		}
		echo $output;
	}
	
	public static function rend_content_end($content_end=false){
		if($content_end==false){
			$output = "";
		}else{
			$output = "</div></div>";
		}
		echo $output;
	}
	
	
	public static function master_header($title,$icon,$title_heading,$content_start=null){
		if(!Users::is_loggedin()){
			require_once "views/user/login/index.php";
			die();
		}else{
			self::rend_header($title);
			require_once "inc/temp/admin/menu_top.php";
			require_once "inc/temp/admin/menu_left.php";
			self::rend_page_heading($icon,$title_heading);
			self::rend_content_start($content_start);
		}
		
	}
	
	public static function master_footer($content_end=false){
		self::rend_content_end($content_end);
		require_once "inc/temp/admin/footer.php";
	}

}
	
?>




