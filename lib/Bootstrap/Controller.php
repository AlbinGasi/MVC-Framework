<?php
namespace lib\Bootstrap;
use lib\models\Config;
use lib\models\Users;

class Controller
{
	public function __construct(){
		$this->view = new View();
	}

	public static function check_user_status($k,$v,$exception=''){
		if($k == 'admin'){
			if($v == true){
				if(!Users::is_admin()){
					header('Location: ' . Config::SITE_URL. '/error/permission_denied');
				}
			}
		}else if($k == 'moderator'){
			if($v == true){
				if(!Users::is_moderator()){
					header('Location: ' . Config::SITE_URL. '/error/permission_denied');
				}
			}
		}else if($k == 'assistant'){
			if($v == true){
				if(!Users::is_assistant()){
					header('Location: ' . Config::SITE_URL. '/error/permission_denied');
				}
			}
		}else if($k == 'advanceduser'){
			if($v == true){
				if(!Users::is_advanced_user()){
					header('Location: ' . Config::SITE_URL. '/error/permission_denied');
				}
			}
		}else if($k == 'simpleuser'){
			if($v == true){
				if(!Users::is_simple_user()){
					if($exception == 'simpleuser'){
						header('Location: ' . Config::SITE_URL. '/account/login');
					}else{
						header('Location: ' . Config::SITE_URL. '/error/permission_denied');
					}
				}
			}
		}
	}

	public static function secured_login($permision){
		if(isset($permision['login']) && $permision['login'] == true){
			if(!Users::is_loggedin()){
				header('Location: ' . Config::SITE_URL. '/account/login');
			}else{
				if(count($permision) > 0){
					foreach($permision as $k => $v){
						self::check_user_status($k,$v,'simpleuser');
					}
				}
			}
		}else{
			foreach($permision as $k => $v){
				self::check_user_status($k,$v,'simpleuser');
			}
		}
	}

	public function __transformation($pageName,$action = null){
		if($action !== null){
			$action = $action . '/';
		}
		if(file_exists(Config::PUBLIC_HTML . '/pages/'.$action . $pageName . '.php')){
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
				$this->view->pageName = $action . $pageName;
			}
			$model_name =  $this->get_model($pageName);
			$this->view->model = new $model_name;
		}else{
			if($action === 'index/'){
				if(file_exists(Config::SITE_URL . '/'. Config::DASHBOARD_NAME . '/show_news_classic.php')){
					$json = file_get_contents(Config::SITE_URL . '/'. Config::DASHBOARD_NAME . '/getjson/pages?pagename='.$pageName);
					$obj = json_decode($json);
				}else{
					$obj = 'none';
				}
			}else{
				$obj = 'none';
			}

			if($obj != 'none'){
				$this->view->has_page_file = false;
				$this->view->has_page = true;
				$this->view->page = $obj;
				$this->view->title = ucfirst($obj->post_title) . ' | ' . $this->_title;
			}else{
				$this->view->has_page = false;
				$this->view->has_page_file = true;
				$this->view->pageName = $action . 'index';
				$this->view->title = rtrim(ucfirst($action),'/') . ' | ' . $this->_title;
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