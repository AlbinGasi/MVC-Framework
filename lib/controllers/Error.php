<?php
namespace lib\controllers;
class Error extends \lib\Bootstrap\Controller
{
	public function index(){
		$this->view->title = 'Error';
		$this->view->render("error/index");
	}
}

?>