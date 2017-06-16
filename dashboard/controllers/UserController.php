<?php

class UserController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
	
	public function index(){
		if(Admin::can_view()){
			$this->view->render("user/index");
		}else{
			$this->view->render("default/index");
		}
	}
	
	public function login(){
		$this->view->render("user/login/index");
	}
	public function login_data(){
		$this->view->render("user/login/login_data");
	}
	
	public function logout(){
		$this->view->render("user/logout/index");
	}
	
	public function register_data(){
		$this->view->render("user/register/register_data");
	}
	
	public function activation($activation=null){
		$this->view->activation_code = $activation;
		$this->view->render("user/activation/index");
	}
	
	public function resend_activation(){
		$this->view->render("user/activation/resend_activation");
	}
	
	public function password_forgot(){
		$this->view->render("user/psw_forget/password_forgot");
	}
	
	public function forgot_data(){
		$this->view->render("user/psw_forget/forgot_data");
	}
	
	public function set_new_password($new_psw=null){
		$this->view->new_psw = $new_psw;
		$this->view->render("user/psw_forget/set_new_password");
	}
	
	public function change_new_password($new_psw=null){
		$this->view->new_psw = $new_psw;
		$this->view->render("user/psw_forget/change_new_password");
	}
	
	public function profil($username=null){
		if(Admin::can_view()){
			$this->view->username = $username;
			$this->view->render("user/profil/view");
		}else{
			$this->view->render("default/index");
		}
	}
	
	public function edit($username=null){
		if(Admin::can_view()){
			$this->view->username = $username;
			$this->view->render("user/profil/edit");
		}else{
			$this->view->render("default/index");
		}
	}
	public function edit_data($username=null){
		$this->view->username = $username;
		$this->view->render("user/profil/edit_data");
	}
	
	public function delete_user($user_id=null){
		$this->view->render("user/delete_user/delete_user");
	}
	
	public function blockeduser(){
		$this->view->render("user/view/blocked_user");
	}
	
	public function adminuser(){
		$this->view->render("user/view/admin_user");
	}
	
	public function moderatoruser(){
		$this->view->render("user/view/moderator_user");
	}
	
	public function writeruser(){
		$this->view->render("user/view/writer_user");
	}
	
	public function changepsw(){
		$this->view->render("user/profil/changepsw_data");
	}
	
	
}


?>