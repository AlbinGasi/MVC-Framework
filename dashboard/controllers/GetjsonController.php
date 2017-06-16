<?php

class GetjsonController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
	
	public function index(){
		
	}

	public function blog($data = null){
		$this->view->blog = new Get;
		$this->view->render('get/json/blog');
	}

	public function blog_name($data = null){
		$this->view->blog = new Get;
		$this->view->render('get/json/blog_name');
	}

	public function pages($data = null){
		$this->view->blog = new Get;
		$this->view->render('get/json/pages');
	}
	
	
	
	
}


?>