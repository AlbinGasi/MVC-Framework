<?php
spl_autoload_register(function($modelName){
	 $modelName = str_replace("\\","/",$modelName);
	if( file_exists($modelName .'.php')) {
		require_once $modelName .'.php';
	}
});
?>