<!DOCTYPE html>
<html >
  <head>
  <?php SiteFunc::get_path(); ?>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel='icon' href='public/img/uniicon.png' type='image/png'>
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

/*
**************************************
*/
		
	   </style>
		
  </head>

  <body>
<div id="info" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
  <div class="modal-header-reg">Information</div>
    <div class="close-reg">x</div>
	<div style="margin-top:25px;margin-bottom:5px;" id="info_msg">
	</div>
	<div id="activation_button"></div>
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
  <div class="modal-header-reg">Resend Activation</div>
  <div class="close-reg">x</div>
	<div class="modal-view-content">
		<div id="resend-act"></div>
		<div style="margin-top:30px;" class="form-group">
		  <input type="text" class="form-control" id="resend_email" placeholder="Enter your email...">
		</div>
		 <button type="button" id="resend_act_code" class="btn btn-primary">Resend activation code</button>
		 <div style="margin-top:5px;" id="resend_msg"></div>
	</div>
  </div>

</div>
  
  
  
    <div class="form">
      
      <ul class="tab-group">
        <li onclick="change_title_login()" class="tab active"><a href="#login">Log In</a></li>
        <li onclick="change_title_signup()" class="tab"><a id="redclearinput" href="#signup">Register</a></li>
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
        <div id="login">   
        <form id="use1form" autocomplete="off" method="POST">
            <div class="field-wrap">
            <label id="ff_uname">
              Username<span class="req">*</span>
            </label>
            <input name="username_l" type="text" autocomplete="off">
          </div>
          
          <div class="field-wrap">
            <label id="ff_pass">
              Password<span class="req">*</span>
            </label>
            <input name="password_l" type="password" autocomplete="off">
          </div>
          
          <p class="forgot"><a href="user/password_forgot">Forgot Password?</a></p>
          
          <button type="submit" id="btn_submit" class="button button-block"/>Log In</button>
          </form>
        </div>

<?php
$path = Config::get("path");
?>
<input id="path" type="hidden" name="path" value="<?php echo $path; ?>">
<script>
var path;
path = document.getElementById("path").value;	
</script>
		
		
<script src="public/js/custom/login_page.js"></script>
		
<?php
		
	
		
		
?>
		
		
		
		<div id="signup"> 
		<script>
$(function(){
	$("#redclearinput").click(function(){
		$("#first-name").val("");
		
		$("#last-name").val("");
		$("#username_r").val("");
		$("#email").val("");
		$("#r_password").val("");
	});
});
</script> 
          <h1>Register new account</h1>

          <div class="top-row">
          <form id="use2form" method="POST">
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
          
          <button type="submit" id="btn_register" type="button" class="button button-block"/>Register</button>
		</form>
        </div>
      </div><!-- tab-content -->

	  
<script src="public/js/custom/login_page2.js"></script>

      
</div> <!-- /form -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="public/user/js/index.js"></script>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    
    
  </body>
</html>
