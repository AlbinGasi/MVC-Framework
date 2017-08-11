<?php
namespace lib\controllers;
class Error extends \lib\Bootstrap\Controller
{
	public function index(){
		$this->view->title = 'Error';
		$this->view->render("error/index");
	}

	public function permission_denied(){
		$this->view->title = 'Permission Denied';
		$this->view->render("error/permission-denied");
	}
}

?>