<?php
//header("Content-Type: application/json; charset=UTF-8"); 
use lib\models\Users;
use lib\models\Alerts;
use lib\models\Config;
get_header('account/register/header',$this->title);
echo set_style('/public/css/account/register.css');
get_templates(['template_name'=>'configvalues']);


if(!\lib\models\Users::is_loggedin()){
?>

<div class="login-page">
  <div class="form">

    <form class="login-form" method="POST" action="#">
      <input type="email" name="email" placeholder="Email" required>
      <button type="submit" name="btn_pasw_change">send</button>
      <br><br>
    </form>

<?php
$users = new lib\models\Users;
if(isset($_POST['btn_pasw_change'])){
	$email = trim($_POST['email']);
	$user = new Users;
	$validate = true;
	if(empty($email)){
		Alerts::get_alert("danger","Error! ","Insert email.");
		$validate = false;
	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		Alerts::get_alert("danger","Error! ","Insert valid Email address.");
		$validate = false;
	}else if(!$user->email_exists($email)){
		Alerts::get_alert("danger","Error!","Email no exist.");
		$validate = false;
	}

	if($validate === true){
		$user_id = $user->get_user_id_from_email($email);
		
		$new_psw = md5(uniqid());
		$user->new_psw = $new_psw;
		$user->update($user_id);
		$user->send_new_password($email,$new_psw);
		Alerts::get_alert("info","Success","Check your email to finish changes.");
	}

}
?>
</div>
</div>
<?php
echo set_script('/public/js/account/register.js');
get_footer('account/register/footer');
}else{
	$url = \lib\models\Config::SITE_URL;
	echo '<input type="hidden" id="path" value="'.$url.'">';
	echo "<script>var url = document.getElementById('path').value;window.location.href=url</script>";
}
?>