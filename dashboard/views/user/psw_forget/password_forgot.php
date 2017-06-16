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


    <div class="form">
      

      
      <div class="tab-content">
        <div id="login">   
        <form id="use3form" method="POST">
            <div class="field-wrap">
            <label>
              Email<span class="req">*</span>
            </label>
            <input id="email_pswforget" name="username_l" type="text">
          </div>
      
          <button type="submit" id="btn_newpsw" class="button button-block"/>Send new password</button>
          </form>
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
	$("#use3form").on("submit",function(e){
		$("#answer").html('<div style="margin:5px auto 0 auto;width:25px;"><img src="public/img/loading.gif" width="22">');
			var email;
			email = $("#email_pswforget").val();
			$.ajax({
				url: 'user/forgot_data',
				type: 'post',
				data: {'email':email},
				success: function(msg){
					$("#answer").html(msg);
					check_succes = $("#msg_val").html();
				}
			});
			e.preventDefault();
	});
});




</script>
		
		


      </div><!-- tab-content -->

	  
      
</div> <!-- /form -->
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="public/user/js/index.js"></script>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    
    
  </body>
</html>
