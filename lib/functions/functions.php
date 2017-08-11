<?php

function set_header_script(){
	echo set_script('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js');
	//echo set_script('/public/js/angular.min.js');
	//echo set_script('/public/js/angular-route.min.js');
	echo set_style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
	echo set_style('/public/css/index/style.css');
}

function set_footer_script(){
	echo set_script('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js');
	echo set_script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
}



?>