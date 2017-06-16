<?php

function set_header_script(){
	echo set_script('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js');
	echo set_script('public/js/angular.min.js');
	echo set_script('public/js/angular-route.min.js');
}

function set_footer_script(){
	echo set_script('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js');
}



?>