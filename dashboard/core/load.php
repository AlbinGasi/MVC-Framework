<?php 
spl_autoload_register(function($className){
	if(file_exists("controllers/{$className}.php")){
		require_once "controllers/{$className}.php";
	}else if(file_exists("models/{$className}.model.php")){
		require_once "models/{$className}.model.php";
	}else if(file_exists("libs/{$className}.php")){
		require_once "libs/{$className}.php";
	}

});
?>