<!DOCTYPE html>
<html >
  <head>
  <?php SiteFunc::get_path(); ?>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" href="public/user/css/normalize.css">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
	<script src='public/js/jquery.js'></script>

        <link rel="stylesheet" href="public/user/css/style.css">
       <style>	
		.alert-info, .alert-success, .alert-warning, .alert-danger, .alert-validation {
			border: 1px solid;
			margin: 10px 0px;
			padding:15px 10px 15px 50px;
			background-repeat: no-repeat;
			background-position: 10px center;
			border-radius:4px;
			}
			.alert-info {
			color: #00529B;
			background-color: #BDE5F8;
			}
			.alert-success {
			color: #4F8A10;
			background-color: #DFF2BF;
			}
			.alert-warning {
			color: #9F6000;
			background-color: #FEEFB3;
			}
			.alert-danger {
			color: #D8000C;
			background-color: #FFBABA;
			//background-image: url('error.png');
}

.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 50%; /* Could be more or less, depending on screen size */
	border-radius:8px;
	position:relative;
}


/* The Close Button */
.close {
    color: #585858;
	position:absolute;
	right:10px;
	top:-5px;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
		
/*
**************** SECOND MODAL STYLE
*/	
.modal-reg {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content-reg {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 50%; /* Could be more or less, depending on screen size */
	min-height: 200px;
	border-radius:8px;
	position:relative;
}

.modal-header-reg {
	width:100%;
	height:40px;
	background-color: #1ab188;
	position:absolute;
	top:0px;
	left:0px;
	border-top-left-radius: 6px;
	border-top-right-radius: 6px;
	text-align:center;
	font-size:24px;
	color: #fff;
}

/* The Close Button */
.close-reg {
    color: #585858;
	position:absolute;
	right:10px;
	top:-5px;
    font-size: 28px;
    font-weight: bold;
}

.close-reg:hover,
.close-reg:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

#register-content {
	margin-top:25px;
}
.modal-view-content {
	margin-top:25px;
}

/*
**************************************
*/

#activation-msg {
	width:100%;
	background-color: #fff;
	min-height:80px;
	margin: 0 auto;
	
}
		
	   </style>
		
  </head>

  <body>

<div id="info" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
  <div class="modal-header-reg">Information</div>
    <div class="close-reg">x</div>
	<div style="margin-top:25px;" id="info_msg">
	</div>
	<div style="width:50px;margin:0 auto;" class="loading-info"></div>
  </div>

</div>
<div id="register-modal" class="modal-reg">
  <!-- Modal content -->
  <div class="modal-content-reg">
  <div class="modal-header-reg">Register</div>
  <div class="close-reg">x</div>
	<div id="register-content">

	</div>
  </div>

</div>
<div id="modal-resend" class="modal-reg">
  <!-- Modal content -->
  <div class="modal-content-reg">
  <div class="modal-header-reg">Resend</div>
  <div class="close-reg">x</div>
	<div class="modal-view-content">
		<div id="resend-act"></div>
		<div class="form-group">
		  <input type="text" class="form-control" id="resend_email" placeholder="Enter your email...">
		</div>
		 <button type="button" id="resend_act_code" class="btn btn-primary">Resend activation code</button>
		 <div style="margin-top:5px;" id="resend_msg"></div>
	</div>
  </div>

</div>
  
 <?php
$path = Config::get("path");
?>
<input id="path" type="hidden" name="path" value="<?php echo $path; ?>">
<script>
var path;
path = document.getElementById("path").value;	
</script>
  
    <div class="form">
      
      <ul class="tab-group">
        <li onclick="change_title_login()" class="tab"><a href="#login">Log In</a></li>
        <li onclick="change_title_signup()" class="tab"><a href="#signup">Register</a></li>
      </ul>
	  
	  <script>
		var title;
		title = document.getElementsByTagName("title")[0];
		function change_title_login(){
			title.innerHTML = "Login";
		}
		function change_title_signup(){
			title.innerHTML = "Sign Up";
		}
	  
	  </script>
      
      <div class="tab-content">
	  
	  <div>

	  <?php
		if(Users_gen::check_activation_code($this->activation_code)){
			$user_id = Users_gen::get_user_id_from_activation($this->activation_code);
			$userdata = Users::get_by_id($user_id);
			
			if($userdata->user_status == 1){
				if($userdata->user_activation == $this->activation_code){
					$update_user_status = new Users;
					$update_user_status->user_status = 2;
					$update_user_status->update($user_id,$userdata->username);
					Alerts::get_alert("info","Successful","Your account is activated");
				}
				
			}else if($userdata->user_status == 2){
				Alerts::get_alert("danger","You are already activated.");
			}
		
		}else{
			Alerts::get_alert("danger","Your activation code is wrong.");
		}
	  
	  ?>
	  
	  
	   <button style="font-size:20px;height:40px;padding-top:5px;" id="btn_resend" class="button button-block"/>Resend activation code</button>
	   
	   <script>
		$(function(){
			$("#btn_resend").click(function(){
				$("#resend_email").val("");
				$("#resend_msg").html("");
				show_resend_activation_modal("#modal-resend");
				
			});
			
			$(document).on("click","#resend_act_code", function(){
				$("#resend_msg").html('<div style="margin:5px auto 0 auto;width:25px;"><img src="public/img/loading.gif" width="22">');
				var email;
				email = $("#resend_email").val();
				$.ajax({
				url: path+'user/resend_activation',
				type: 'post',
				data: {'email_resend':email},
				success: function(msg){
					$("#resend_msg").html(msg);
					check_succes = $("#msg_val").html();
				}
			});
			});

				
		});
	   
	   
	   </script>
	   
	   
	   
	  </div>
	 
	  
	  
	  
	  
	  
        <div id="login" style="display:none;">   
            <div class="field-wrap">
            <label>
              Username<span class="req">*</span>
            </label>
            <input name="username_l" type="text">
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input name="password_l" type="password">
          </div>
          
          <p class="forgot"><a href="user/password_forgot">Forgot Password?</a></p>
          
          <button id="btn_submit" class="button button-block"/>Log In</button>
        </div>


		
		
<script>

var modal = $("#info");
var close_info = $(".close-reg");

close_info.click(function(){
	modal.css("display","none");
});

function show_modal(){
	modal.fadeIn(250,function(){
		//modal.css({"display":"block"});
	});

}

/* SECOND MODAL */

var modal_reg = $("#register-modal");
var close_reg = $(".close-reg");
var close_reg_act = $(".close-reg");

close_reg.click(function(){
	modal_reg.css("display","none");
});

function show_register_modal(){
	modal_reg.fadeIn(250,function(){
	});
}


/* END */

function show_resend_activation_modal(cus_modal){
	$(cus_modal).fadeIn(250,function(){
	});
}
close_reg_act.click(function(){
	$("#modal-resend").css("display","none");
});

$(function(){
	
	$("#btn_submit").click(function(){
		var username,password,errors;
		username = $("input[name='username_l']").val();
		password = $("input[name='password_l']").val();

		errors = "";
		if(username.trim() == ""){
			errors += "<p>Enter your username</p>";
		}
		if(password.trim() == ""){
			errors += "<p>Enter your password</p>";
		}
		
		if(errors != ""){
			$("#info_msg").html("<div class='alert-danger'>"+errors+"</div>");
			show_modal();
			
		}else{
			$.ajax({
				url: path+'user/login_data',
				type: 'post',
				data: {'username':username,"password":password},
				success: function(msg){
					$("#info_msg").html(msg);
					check_succes = $("#msg_val").html();
					if(check_succes == "Successful"){
						$(".loading-info").html('<img src="public/img/loading.gif" width="40">');
						show_modal();
						setTimeout(function(){
							window.open('index/','_self');
						}, 2000);
					}else{
						show_modal();
					}
					

					
				}
			});
		}
		
	});
});
		
		
		
</script>
		
<?php
		
	
		
		
?>
		
		
		
		<div id="signup">   
          <h1>Register new account</h1>

          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input id="first-name" type="text" required autocomplete="off" />
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input id="last-name" type="text" required autocomplete="off"/>
            </div>
          </div>
		  <div class="field-wrap">
            <label>
              Username<span class="req">*</span>
            </label>
            <input id="username_r" type="text" required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input id="email" type="email" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input id="r_password" type="password" required autocomplete="off"/>
          </div>
          
          <button id="btn_register" type="button" class="button button-block"/>Register</button>

        </div>
      </div><!-- tab-content -->
	  <script>
$(function(){
	$(document).on("click","#btn_register", function(){
		$("#register-content").html('<div style="margin:5px auto 0 auto;width:25px;"><img src="public/img/loading.gif" width="22">');
		show_register_modal();
		
		var r_fname,r_lname,r_username,r_email,r_password;
		
		r_fname = $("#first-name").val();
		r_lname = $("#last-name").val();
		r_username = $("#username_r").val();
		r_email = $("#email").val();
		r_password = $("#r_password").val();
		
		$.ajax({
			url: path+'user/register_data',
			type: 'post',
			data: {'first_name':r_fname,'last_name':r_lname,'username':r_username,'email':r_email,'password':r_password},
			success: function(msg){
				$("#register-content").html(msg);
				show_register_modal();
			}
		});

	});
});
	
</script>
	  
      
</div> <!-- /form -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="public/user/js/index.js"></script>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    
    
  </body>
</html>
