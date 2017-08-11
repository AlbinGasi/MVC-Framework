<?php
namespace lib\controllers;
class Account extends \lib\Bootstrap\Controller
{
	public $_title = \lib\models\Config::SITE_TITLE;

	public function index($pageName = null){
		self::secured_login(['login'=>true]);
		$this->__transformation($pageName, 'account'); //This method find in \lib\Bootstrap\Controller@__transformation
		$this->view->render("account/index");
	}

	public function login($pageName = null){
		$this->view->title = "Login";
		$this->view->render("account/login");
	}

	public function logout($pageName = null){
		$this->view->title = "Logout";
		$this->view->render("account/logout");
	}

	public function check_data_for_register($pageName = null){
		$this->view->title = "Register";
		$this->view->render("account/check_data_for_register");
	}

	public function activation($activation = null){
		$this->view->title = "Activation";
		$this->view->activation_code = $activation;
		$this->view->render("account/activation");
	}

	public function setnewpassword($password = null){
		$this->view->title = "Change password";
		$this->view->password = $password;
		$this->view->render("account/setnewpassword");
	}
	public function getnewpassword($password = null){
		$this->view->title = "Get new password";
		$this->view->password = $password;
		$this->view->render("account/getnewpassword");
	}
}

?>