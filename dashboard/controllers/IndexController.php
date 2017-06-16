<?php

class IndexController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
    	$this->view->index = new Index;
        $this->view->render("index/index");
    }
    
    public function user_activity(){
    	$this->view->index = new Index;
    	$this->view->render("index/user_activity");
    }
    
    public function user_activity_delete(){
    	$this->view->index = new Index;
    	$this->view->render("index/user_activity_delete");
    }
    
    public function user_activity_load(){
    	$this->view->index = new Index;
    	$this->view->render("index/user_activity_load");
    }
}


?>