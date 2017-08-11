<?php
use lib\models\Users;
use lib\models\Alerts;
use lib\models\Config;

if(!\lib\models\Users::is_loggedin()){

$user = new Users;
get_header('account/register/header',$this->title);
get_templates(['template_name'=>'configvalues']);
echo set_style('/public/css/account/register.css');

if($user->check_new_psw($this->password) !== false){
	$user_id = $user->check_new_psw($this->password);
?>

<div class="login-page">
  <div class="form">
    <form class="login-form" method="POST" action="#">
      <input type="password" name="password" placeholder="Password ..." required>
      <input type="password" name="repassword" placeholder="Retype password ..." required>
      <button type="submit" name="btn_pasw_change">change</button>
      <br><br>
    </form>

<?php
if(isset($_POST['btn_pasw_change'])){
	$password = trim($_POST['password']);
	$repassword = trim($_POST['repassword']);
	$validation = true;

	if(empty($password)){
		Alerts::get_alert("danger","Error! ","Insert password.");
		$validation = false;
	}else if(strlen($password)<=5){
		Alerts::get_alert("danger","Error! ","Password must be longer than 5 characters.");
		$validation = false;
	}
	if(empty($repassword)){
		Alerts::get_alert("danger","Error! ","Insert password.");
		$validation = false;
	}else if(strlen($repassword)<=5){
		Alerts::get_alert("danger","Error! ","Password must be longer than 5 characters.");
		$validation = false;
	}

	if($validation === true){
		if($password == $repassword){
			$user->password = md5($password);
			$user->new_psw = md5(uniqid());
			$user->update($user_id);
			Alerts::get_alert("info","Success","Your password has been changed.");
		}else{
			Alerts::get_alert("danger","Error! ","Passwords do not match.");
		}
	}
}
?>
</div>
</div>
<?php
}else{
	Alerts::get_alert("danger","Error! ","Wrong request");
}
echo set_script('/public/js/account/register.js');
get_footer('account/register/footer');
}else{
	$url = \lib\models\Config::SITE_URL;
	echo '<input type="hidden" id="path" value="'.$url.'">';
	echo "<script>var url = document.getElementById('path').value;window.location.href=url</script>";
}
?>