<?php
spl_autoload_register(function($modelName){
	if( file_exists($modelName .'.php')) {
		require_once $modelName .'.php';
	}
});
?>