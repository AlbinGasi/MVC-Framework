<?php
namespace lib\controllers;
class Kale extends \lib\Bootstrap\Controller
{
	public $_title = \lib\models\Config::SITE_TITLE;

	public function index($pageName = null){
		$this->__transformation($pageName, 'kale/'); //This method find in \lib\Bootstrap\Controller@newGenerationIndex
		$this->view->render("kale/index");
	}

	public function about($pageName = null){
		$this->view->title = 'Kale | About';
		$this->view->render("kale/about");
	}

}

?>