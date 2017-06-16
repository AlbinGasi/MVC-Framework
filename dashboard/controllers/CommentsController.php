<?php

class CommentsController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
	
	public function index($pg=null){
	    $this->view->pg = $pg;
		$this->view->render("comments/index");
	}

	public function addcomment(){
		$this->view->render("comments/addcomment");
	}
	public function lastcomment($id=null){
		$this->view->post_id = $id;
		$this->view->render("comments/lastcomment");
	}

    public function deletecomment(){
		$this->view->render("comments/deletecomment");
	}

    public function editcomment(){
		$this->view->render("comments/editcomment");
	}

    public function shwlstpst($id=null){
        $this->view->post_id = $id;
		$this->view->render("comments/shwlstpst");
	}

    public function adminview(){
		$this->view->render("comments/adminview");
	}

   
	
}


?>