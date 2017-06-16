<?php
namespace lib\Bootstrap;
class View
{
    public function __construct(){

    }

    public function render($name,$data = null){
    	if(file_exists("public/views/{$name}.php")) {
    		require_once "public/views/{$name}.php";
    	} else {
    		echo 'Error. Please check you controller. <br>File: <i>' . 'public/views/' . $name . '.php</i>' . ' doesn\'t exist';
    	}
		
    }

    public function include_script(){
    	
    }
}


?>