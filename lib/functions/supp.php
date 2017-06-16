<?php

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
	return "<script src='" . $src . "'></script>";
}

function set_style($href){
	return "<link href='" . $link . "' rel='stylesheet' type='text/css'>";

}

function has_page_content($has,$content){
	if($has === true){
		include_once 'public/pages/page-from-base.php';
	}
}

function get_page($page,$model){
	if(file_exists('public/pages/'.$page.'.php')){
		include_once 'public/pages/'.$page.'.php';
	}else{
		echo 'Error! The file: <i>public/pages/'.$page.'.php</i> doesn\'t exist!';
	}
	
}



?>