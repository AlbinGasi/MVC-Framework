<?php
namespace lib\controllers;
class Index extends \lib\Bootstrap\Controller
{
	public $_title = \lib\models\Config::SITE_TITLE;

	public function index($pageName = null){
		$this->view->data['name'] = 'Albin';
		$this->view->data['age'] = 25;

		$this->__transformation($pageName, 'index'); //This method find in \lib\Bootstrap\Controller@newGenerationIndex
		$this->view->render("index/index");
	}

	public function blog($data = null){
		$this->view->title = '';
		$this->view->render("blog/blog");
	}
}

?>