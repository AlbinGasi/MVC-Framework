<?php
SiteFunc::master_header("User profil","Profil","<li><a href='user/'>User</a></li><li>Profil edit</li>");
$siteHASH = Config::get('hash_key');
$this->user_id = (isset($_SESSION[$siteHASH ]['user_id'])) ? $_SESSION[$siteHASH ]['user_id'] : -122;
?>

<style>

.selection{
	width:100%;
	padding:8px;
	border: 1px solid #DDD;
	border-radius: 5px;
	
}
.selection option{
	font-size: 15px;
}




</style>
<div id="modal-edit-user" class="modal_cus">
  <!-- Modal content -->
  <div class="modal_cus-content">
  <div class="modal_cus-header">Edit user</div>
  <div class="close_cus">x</div>
	<div class="modal-view-content">
		<div id="message"></div>
		 <div style="margin-top:5px;" id="resend_msg"></div>
	</div>
  </div>
</div>

<div id="modal-set-user-password" class="modal_cus">
  <!-- Modal content -->
  <div class="modal_cus-content">
  <div class="modal_cus-header">Set new password</div>
  <div class="close_cus">x</div>
	<div class="modal-view-content">
	
	<?php
		if(Users::is_admin2($this->user_id)){
	?>
		<div class="col-md-5">
			<h4>Set new password</h4>
		</div>
				<div class="col-md-3">
				<input style="width:200px" type="password" id="new_password1" class="form-control" placeholder="New password">
					<div style="margin-top:5px;"></div>
			<input style="width:200px" type="password" id="new_password2" class="form-control" placeholder="Repeat password">
		</div>
		<div class="col-md-5">

		</div>
		<div class="col-md-3">
		<div style="margin-top:5px;"></div>
			<div style="width:200px;position:relative;"><button style="position:absolute;top:0px;right:0px;" id="send_new_psw" type="button" class="btn btn-primary">Save changes</button></div>
		</div>
		<div class="clearfix"></div>			
							
		<?php
			}			  
		?>
	
	
	
		<div style="margin-top:45px;" id="msg_changepsw"></div>
	</div>
  </div>
</div>

<script>
var modal = $("#modal-edit-user");
var close_info = $(".close_cus");

close_info.click(function(){
	modal.css("display","none");
});

function show_modal(){
	modal.fadeIn(250,function(){
		//modal.css({"display":"block"});
	});
}
	
var modal22 = $("#modal-set-user-password");
var close_info2 = $(".close_cus");

close_info2.click(function(){
	modal22.css("display","none");
});

function show_modal22(){
	modal22.fadeIn(250,function(){
		//modal.css({"display":"block"});
	});
}
	
	



</script>

<?php


if($this->username != null){
if(Users_gen::check_user_by_username($this->username)){
	$user = Users_gen::get_user_by_username($this->username);
	echo "<input type='hidden' id='usrid' value='".$user->user_id."'>";
	echo "<input type='hidden' id='usrname' value='".$user->username."'>";
}else{
	Alerts::get_alert("danger","Error","User does not exist");
	SiteFunc::master_footer();
	return false;
}
}else{
echo "<input type='hidden' id='usrid' value='".$this->user_id."'>";
$user = Users::get_by_id($this->user_id);

echo "<input type='hidden' id='usrname' value='".$user->username."'>";
}

echo "<input type='hidden' id='uri' value='".$_SERVER['REQUEST_URI']."'>";

$status = "N";
if(Users::is_admin2($this->user_id) || Users::is_moderator($this->user_id)){
	$status = "OK";
}
$checkUser = Users::get_by_id($this->user_id);
if($this->username == null || $this->username == $checkUser->username){
	$status = "OK";
}


if($this->username != null){
	$checkUser2 = Users_gen::get_user_by_username($this->username);
	if($checkUser2->user_status == 351){
		if(Users::is_admin2($this->user_id)){
			$status = "OK";
		}else{
			$status = "N";
		}
	}
}

if($status == "OK"){
?>

 <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10 toppad">
		<!--div class ="col-md-offset-8 toppad"-->
          <div class="panel panel-info">
		  <div class="panel-heading">
              <h3 class="panel-title"><?php echo ucfirst($user->first_name) . " " . ucfirst($user->last_name);  ?></h3>
          </div>


            <div class="panel-body">
              <div class="row">
                <!--div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="http://babyinfoforyou.com/wp-content/uploads/2014/10/avatar-300x300.png" class="img-circle img-responsive"> </div-->

                <div class="col-md-9 col-lg-9"> 
                  <table class="table table-user-information">
                    <tbody>
					<tr>
                        <td colspan="2">First Name:</td>
                        <td colspan="3"><input type="text" id="first_name" class="form-control" value="<?php echo ucfirst($user->first_name); ?>"></td>
                      </tr>
					  <tr>
                        <td colspan="2">Last Name:</td>
                        <td colspan="3">
						<input type="text" id="last_name" class="form-control" value="<?php echo ucfirst($user->last_name); ?>">
						</td>
                      </tr>
                      <tr>
                        <td colspan="2">Username:</td>
                        <td colspan="3">
						<input type="text" id="username" class="form-control" value="<?php echo ucfirst($user->username); ?>">
						</td>
                      </tr>
                      <tr>
                        <td colspan="2">Date of Birth:</td>
                        <td><input type="text" id="birth_date_d" class="form-control" value="<?php echo Users_gen::get_user_age_for_editing($user->born_date,"d"); ?>" placeholder="Day"></td>
						<td><input type="text" id="birth_date_m" class="form-control" value="<?php echo Users_gen::get_user_age_for_editing($user->born_date,"m"); ?>" placeholder="Month"></td>
						<td><input type="text" id="birth_date_y" class="form-control" value="<?php echo Users_gen::get_user_age_for_editing($user->born_date,"y"); ?>" placeholder="Year"></td>
                      </tr>
                         <tr>
                             <tr>
                        <td colspan="2">Gender:</td>
                        <td colspan="3">
						<select id="user_gender" class="selection">
						<option value=""></option>
						<?php
							$gender = Users_gen::get_gender();
							$current_gender = $user->user_gender;
							
							foreach($gender as $all_gender){
								if($all_gender == $current_gender){
									echo "<option selected value='".$all_gender."'>".ucfirst($all_gender)."</option>";
									continue;
								}
								echo "<option value='".$all_gender."'>".ucfirst($all_gender)."</option>";
								
								
							}
						
						?>
						</select>
						</td>
                      </tr>
                        <tr>
                        <td colspan="2">Home Address:</td>
                        <td colspan="3">						
						<input type="text" id="home_address" class="form-control" value="<?php echo $user->user_address; ?>">
						</td>
                      </tr>
                      <tr>
                        <td colspan="2">Email:</td>
                        <td colspan="3">
						<input type="text" id="email" class="form-control" value="<?php echo $user->email; ?>">
						</td>
                      </tr>
					   <tr>
                        <td colspan="2">User status:</td>
                        <td colspan="3">
						<?php
						if(Users::is_admin2($this->user_id)){
							$all_status = Users_status::get_all_status();
							$current_status = Users_status::get_user_status($user->user_status);
							
							echo "<select id='user_status' class='selection'>";
							foreach($all_status as $status){
								if($status['status_name'] == $current_status){
									echo "<option selected value='".$current_status."' >".$current_status."</option>";
									continue;
								}
								if($status['status_name'] == "Owner"){
									continue;
								}
								
								echo "<option value='".$status['status_name']."'>".$status['status_name']."</option>";	
							}
						}else{
							 echo Users_status::get_user_status($user->user_status);
						}
						?>
						
                      
					  
					  
					  </tr>
					  <tr>
                        <td colspan="2">Phone Number:</td>
                        <td colspan="3">
						<input type="text" id="phone_number" class="form-control" value="<?php echo $user->phone_number; ?>">
						</td>
                      </tr>
					  
					  <?php
						if(Users::is_admin2($this->user_id)){
							?>
							 <tr>
								<td colspan="2">Password:</td>
								<td colspan="3">
								<button id="set_new_password" type="button" class="btn btn-default">Set a new password</button>
								</td>
							 </tr>
							
							
							<?php
						}
					  
					  ?>
					  
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
                 <div class="panel-footer">
				 <a href="user/profil/<?php echo $this->username;  ?>" class="btn btn-default" role="button">View profil</a>
                     	<span class="pull-right">
							<button id="edit_user" type="button" class="btn btn-primary">Save changes</button>
						</span>
                    </div>
            
          </div>
        </div>
		
      </div>
	  
	  <div id="msg_edit_user"></div>

<script>
	$(function(){
		
		var setNewPassword = $("#set_new_password");
		
		setNewPassword.click(function(){
			 $("#new_password1").val("");
			 $("#new_password2").val("");
			 $("#msg_changepsw").html("");
			show_modal22();
		});
		
		$(document).on("click","#send_new_psw",function(){
			var userId = $("#usrid").val();
			var userName = $("#usrname").val();
			var password1 = $("#new_password1").val();
			var password2 = $("#new_password2").val();
			
			$.ajax({
				url: 'user/changepsw',
				type: 'post',
				data: {'userid':userId,'userName':userName,'password1':password1,'password2':password2},
				success: function(msg2){
					$("#msg_changepsw").html(msg2);
				}
			});
			
		});
		
		
		var saveChanges = $("#edit_user");
		
		saveChanges.click(function(){
			first_name = $("#first_name").val();
			last_name = $("#last_name").val();
			username = $("#username").val();
			birth_date_d = $("#birth_date_d").val();
			birth_date_m = $("#birth_date_m").val();
			birth_date_y = $("#birth_date_y").val();
			gender = $("#user_gender").val();
			home_address = $("#home_address").val();
			email = $("#email").val();
			user_status = $("#user_status").val();
			phone_number = $("#phone_number").val();
			usrname = $("#usrname").val();
			
			$.ajax({
				url: 'user/edit_data',
				type: 'post',
				data: {"first_name":first_name,"last_name":last_name,"username":username,"birth_d":birth_date_d,"birth_m":birth_date_m,"birth_y":birth_date_y,"gender":gender,"usrname":usrname,"home_address":home_address,"email":email,"user_status":user_status,"phone_number":phone_number},
				success: function(msg){
					$("#message").html(msg);
					show_modal();
				}
			});
			
		});
	});

</script>



<?php
}else{
	Alerts::get_alert("danger","Error!"," You don't have a privilegies.");
}
SiteFunc::master_footer();
?>