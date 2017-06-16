<?php

class MediaController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
    public function index($pg=null,$param3=null){
    	if(Admin::can_view()){
			$this->view->pg = $pg;
			$this->view->params3 = $param3;
        	$this->view->render("media/index");
    	}else{
    		$this->view->render("default/index");
    	}
    }
	
	public function admin_view_gallery(){
        $this->view->render("media/admin_view_gallery");
    }

	public function library(){
		if(Admin::can_view()){
        	$this->view->render("media/library");
		}else{
			$this->view->render("default/index");
		}
    }
	
	public function library_load_more(){
        $this->view->render("media/library_load_more");
    }
	
	public function delete(){
        $this->view->render("media/delete");
    }	
}


?>