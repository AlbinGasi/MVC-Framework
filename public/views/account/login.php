<?php
//header("Content-Type: application/json; charset=UTF-8"); 
get_header('account/register/header',$this->title);
echo set_style('/public/css/account/register.css');

get_templates(['template_name'=>'configvalues']);

if(!\lib\models\Users::is_loggedin()){
?>

<div class="login-page">
  <div class="form">
    <form id="register" class="register-form" method="POST">
    	<input type="text" name="username" placeholder="Username" required>
    	<span class="errorMessage username"></span>
      <input type="text" name="first_name" placeholder="First Name" required>
      <span class="errorMessage first_name"></span>
      <input type="text" name="last_name" placeholder="Last Name" required>
      <span class="errorMessage last_name"></span>
      <input type="date" name="born" placeholder="Born">
      <span class="errorMessage born"></span>
      <input type="email" name="email" placeholder="Email address"/>
      <span class="errorMessage email"></span>
      <input type="password" name="password" placeholder="Enter password"/>
      <span class="errorMessage password"></span>
      <input type="password" name="repassword" placeholder="Repeat password"/>
      <span class="errorMessage repassword"></span>
      
      <button style="position: relative;" type="submit" name="btn_create" disabled>Sign up
      	<div id="loadingImg">
      	<img src="<?php echo IMAGES_DIR ?>loading.gif">
      </div>
      </button>
      <p class="message">Already registered? <a href="#">Sign In</a></p>
      <div style="clear:both;"></div>
      <p id="msgReg"></p>
      
    </form>
    <form class="login-form" method="POST" action="#">
      <input type="text" name="usernameL" placeholder="Email or Username" required>
      <input type="password" name="passwordL" placeholder="Password" required>
      <button type="submit" name="btn_login">login</button>
      <p class="message"><a href="#">Create an account</a></p>
      <p class="message2"><a href="<?php echo SITE_URL ?>/account/getnewpassword">Forgot password?</a></p>
      <div style="clear:both;"></div>
      <br><br>
    </form>

<?php
$users = new lib\models\Users;
if(isset($_POST['btn_login'])){
	$log1 = trim($_POST['usernameL']);
	$password = trim($_POST['passwordL']);
	$users->user_login(['log1'=>$log1,'password'=>md5($password)]);
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