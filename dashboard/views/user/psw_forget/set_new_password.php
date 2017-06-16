<!DOCTYPE html>
<html >
  <head>
  <?php SiteFunc::get_path(); ?>
    <meta charset="UTF-8">
    <title>New password</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" href="public/user/css/normalize.css">
	<link rel="stylesheet" href="public/css/bootstrap.min.css">
	<script src='public/js/jquery.js'></script>
	<link rel="stylesheet" href="public/user/css/style.css">

		
  </head>

  <body>


    
      
<?php
	if(Users_gen::check_new_psw($this->new_psw)){
		$user_id = Users_gen::get_id_by_new_psw($this->new_psw);
?>
      <div class="form">
      <div class="tab-content">
        <div id="login">   
            <div class="field-wrap">
            <label>
              Your new password:<span class="req">*</span>
            </label>
            <input id="new_password" name="new_password" type="password">
			 <input type="hidden" id="usridfunc" value="<?php echo $user_id; ?>">
			 <input type="hidden" id="new_psw" value="<?php echo $this->new_psw; ?>">
          </div>

          <button id="btn_newpsw" class="button button-block"/>Update</button>
        </div>
		
		<div style="margin-top:7px;" id="answer"></div>

<?php
$path = Config::get("path");
?>
<input id="path" type="hidden" name="path" value="<?php echo $path; ?>">
<script>
var path;
path = document.getElementById("path").value;	

$(function(){
	$("#btn_newpsw").click(function(){
		$("#answer").html('<div style="margin:5px auto 0 auto;width:25px;"><img src="public/img/loading.gif" width="22">');
			var email;
			password = $("#new_password").val();
			id = $("#usridfunc").val();
			new_psw = $("#new_psw").val();
			$.ajax({
				url: 'user/change_new_password',
				type: 'post',
				data: {'new_psw':new_psw,'id':id,'password':password},
				success: function(msg){
					$("#answer").html(msg);
					check_succes = $("#msg_val").html();
					$("#new_password").val("");
					if(check_succes == "Success"){
						setTimeout(function(){
							window.open(path+'user/login','_self');
						}, 1300);
					}
				}
			});
	});
});




</script>
   </div><!-- tab-content -->
   </div> <!-- /form -->
<?php

}
?>	

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="public/user/js/index.js"></script>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    
    
  </body>
</html>
