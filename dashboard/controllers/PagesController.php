<?php

class PagesController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
	
	public function index($pg=null,$param3=null){
		$this->view->pg = $pg;
		$this->view->params3 = $param3;
		$this->view->render("pages/all");
	}
	
    public function all($pg=null,$param3=null){
    	$this->view->posts_model = new Posts;
		$this->view->pg = $pg;
		$this->view->params3 = $param3;
        $this->view->render("pages/all");
    }
	public function add(){
        $this->view->render("pages/add");
    }
	
	public function edit($id=null){
		$this->view->id = $id;
		$this->view->render("pages/edit");
	}
	
	public function delete(){
		$this->view->render("pages/delete");
	}
	
	public function admin_view($id=null){
		$this->view->id = $id;
		$this->view->render("pages/admin_view");
	}
	
	public function categories(){
		$this->view->render("pages/categories");
	}
	
	public function delete_category(){
		$this->view->render("pages/delete_category");
	}
	
	public function edit_category(){
		$this->view->render("pages/edit_category");
	}
	
	public function post_view($id=null){
		$this->view->id = $id;
		$this->view->render("pages/view/post_view");
	}
	
	
}


?>