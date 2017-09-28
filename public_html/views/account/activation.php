 <?php
 use lib\models\Users;
 use lib\models\Alerts;
 use lib\models\Config;

get_header('account/register/header',$this->title);
echo set_style('/public/css/account/register.css');

get_templates(['template_name'=>'configvalues']);

echo '<div class="login-page">';
 $users = new Users;
		if($users->check_activation_code($this->activation_code)){
			$user_id = $users->get_user_id_from_activation($this->activation_code);
			$userActivation = Users::get_user_by_id($user_id,'user_activation');
			$userStatus = Users::get_user_by_id($user_id,'user_status');
			
			if($userStatus == 1){
				if($userActivation == $this->activation_code){
					$users->user_status = 2;
					$users->update($user_id);
					Alerts::get_alert("info","Successful","Your account is activated. You can login now.");
					echo '<a href="'.Config::SITE_URL.'/account/login">Login</a>';
				}
				
			}else if($userStatus == 2){
				Alerts::get_alert("danger","You are already activated.");
				echo '<a href="'.Config::SITE_URL.'/account/login">Login</a>';
			}
		
		}else{
			Alerts::get_alert("danger","Your activation code is wrong.");
		}
echo '</div>';  
?>