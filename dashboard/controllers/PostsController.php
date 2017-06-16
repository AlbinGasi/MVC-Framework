<?php

class PostsController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
	
	public function index($pg=null,$param3=null){
		$this->view->pg = $pg;
		$this->view->params3 = $param3;
		$this->view->render("posts/all");
	}
	
    public function all($pg=null,$param3=null){
    	$this->view->posts_model = new Posts;
		$this->view->pg = $pg;
		$this->view->params3 = $param3;
        $this->view->render("posts/all");
    }
	public function add(){
        $this->view->render("posts/add");
    }
	
	public function edit($id=null){
		$this->view->id = $id;
		$this->view->render("posts/edit");
	}
	
	public function delete(){
		$this->view->render("posts/delete");
	}
	
	public function admin_view($id=null){
		$this->view->id = $id;
		$this->view->render("posts/admin_view");
	}
	
	public function categories(){
		$this->view->render("posts/categories");
	}
	
	public function delete_category(){
		$this->view->render("posts/delete_category");
	}
	
	public function edit_category(){
		$this->view->render("posts/edit_category");
	}
	
	public function post_view($id=null){
		$this->view->id = $id;
		$this->view->render("posts/view/post_view");
	}
	
	
}


?>