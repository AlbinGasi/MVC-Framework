<?php
namespace lib\Bootstrap;
use lib\models\Config;

class Controller
{
    public function __construct(){
        $this->view = new View();
    }

    public function __transformation($pageName,$action = null){
    	if(file_exists('public/pages/'.$action . $pageName . '.php')){
			for($i=0;$i<strlen($pageName);$i++){
	    		if($i == "-"){
	    			$pageNameTitle = str_replace("-"," ",$pageName);
	    		}
    		}
			$this->view->title = ucfirst($pageNameTitle) . ' | ' . $this->_title;
			$this->view->has_page = false;
			$this->view->has_page_file = true;
			if($action === null){
				$this->view->pageName = $pageName;
			}else{
				$this->view->pageName = $action . '/' .$pageName;
			}
			$model_name =  $this->get_model($pageName);
			$this->view->model = new $model_name;
		}else{
		$json = file_get_contents(Config::SITE_URL . '/'. Config::DASHBOARD_NAME . '/getjson/pages?pagename='.$pageName);
		$obj = json_decode($json);

		if($obj != 'none'){
			$this->view->has_page_file = false;
			$this->view->has_page = true;
			$this->view->page = $obj;
			$this->view->title = ucfirst($obj->post_title) . ' | ' . $this->_title;
		}else{
			$this->view->has_page = false;
			$this->view->has_page_file = true;
			if($action === null){
				$this->view->pageName = 'index';
				$this->view->title = $this->_title;
			}else{
				$this->view->pageName = $action . '/index';
				$this->view->title = rtrim(ucfirst($action),'/') . ' | ' . $this->_title;
			}
			$model_name =  $this->get_model($pageName);
			$this->view->model = new $model_name;
		}
	}
    }

    public function get_model($model){
    	for($i=0;$i<strlen($model);$i++){
	    		if($i == "-"){
	    			$model = str_replace("-","",$model);
	    		}
	    		if($i == " "){
	    			$model = str_replace(" ","",$model);
	    		}
    		}

    		$model_path = 'lib\models\\' . ucfirst($model);

    		if(file_exists($model_path . '.php')){
    			return $model_path;
    		}else{
    			return 'lib\models\Index';
    		}

    }



}




?>