<?php
use \lib\models\Config;

function get_header($data, $title) {
	include_once 'templates/'. $data . '.php';
}

function get_footer($data) {
	include_once 'templates/'. $data . '.php';
}

function get_templates($data) {
	include_once 'templates/'. $data['template_name'] . '.php';
}

function set_title($data) {
	return $data;
}

function set_script($src){
	$src_firstChar = mb_substr($src, 0, 1);
	if($src_firstChar === '/'){
		return "<script src='" . Config::SITE_URL . $src . "'></script>";

	}else{
		return "<script src='" . $src . "'></script>";
	}
}

function set_style($href){
	$href_firstChar = mb_substr($href, 0, 1);
	if($href_firstChar === '/'){
		return "<link href='" . Config::SITE_URL . $href . "' rel='stylesheet' type='text/css'>";
	}else{
		return "<link href='" . $href . "' rel='stylesheet' type='text/css'>";
	}
}

function has_page_content($has,$content){
	if($has === true){
		include_once Config::PUBLIC_HTML . '/pages/page-from-base.php';
	}
}

function get_page($page,$model){
	if(file_exists(Config::PUBLIC_HTML . '/pages/'.$page.'.php')){
		include_once Config::PUBLIC_HTML . '/pages/'.$page.'.php';
	} else if (is_dir(Config::PUBLIC_HTML . '/pages/' .$page)) {
		if(file_exists(Config::PUBLIC_HTML . '/pages/' .$page. '/' . $page . '.php')){
			include_once Config::PUBLIC_HTML . '/pages/'.$page. '/' . $page . '.php';
		}
	} else {
		echo 'Error! The file: <i>'.Config::PUBLIC_HTML .'/pages/'.$page.'.php</i> doesn\'t exist!';
	}
}


?>