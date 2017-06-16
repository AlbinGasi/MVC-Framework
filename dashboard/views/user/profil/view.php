<?php
SiteFunc::master_header("User profil","Profil","<li><a href='user/'>User</a></li><li>Profil view</li>");
$siteHASH = Config::get('hash_key');
$this->user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;

if($this->username != null){
if(Users_gen::check_user_by_username($this->username)){
	$user = Users_gen::get_user_by_username($this->username);
	echo "<input type='hidden' id='usrid' value='".$user->user_id."'>";
}else{
	Alerts::get_alert("danger","Error","User does not exist");
	return false;
}
}else{
echo "<input type='hidden' id='usrid' value='".$this->user_id."'>";
$user = Users::get_by_id($this->user_id);
}

echo "<input type='hidden' id='uri' value='".$_SERVER['REQUEST_URI']."'>";
$checkUser = Users::get_by_id($this->user_id);
?>


<div id="modal-deleted-user" class="modal_cus">
  <!-- Modal content -->
  <div class="modal_cus-content">
  <div class="modal_cus-header">Delete user</div>
  <div class="close_cus">x</div>
	<div class="modal-view-content">
		<div id="message"></div>
		 <div style="margin-top:5px;" id="resend_msg"></div>
	</div>
  </div>
  <script>
	$(document).on("click",".close_cus",function(){
		var uri = $("#uri").val();
		window.open(uri, '_self');
	});
  </script>
</div>

<script>
var modal = $("#modal-deleted-user");
var close_info = $(".close_cus");

close_info.click(function(){
	modal.css("display","none");
});

function show_modal(){
	modal.fadeIn(250,function(){
		//modal.css({"display":"block"});
	});

}

</script>





      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10 toppad">
		
		<?php 
			if($user->user_status == 0){
				if(!Admin::can_view_2()){
					Alerts::get_alert("danger","Error!","You don't have privilegies!");
					SiteFunc::master_footer();
					return false;
				}
			}
		?>
		
		
		<!--div class ="col-md-offset-8 toppad"-->
          <div class="panel panel-info">
		  
		  <?php if($user->user_status == 0){ ?>
            <div style="background:red;" class="panel-heading">
              <h3 style="color:white;" class="panel-title"><?php echo ucfirst($user->first_name) . " " . ucfirst($user->last_name);  ?> <span style="font-size:10px;"> (this user is deactivated, only administrator or moderator can see it)</span></h3>
            </div>
			
		  <?php }else{ ?>
		  <div class="panel-heading">
              <h3 class="panel-title"><?php echo ucfirst($user->first_name) . " " . ucfirst($user->last_name);  ?></h3>
          </div>

		  <?php } ?>
            <div class="panel-body">
              <div class="row">
                <!--div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="http://babyinfoforyou.com/wp-content/uploads/2014/10/avatar-300x300.png" class="img-circle img-responsive"> </div-->

                <div class="col-md-9 col-lg-9"> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Username:</td>
                        <td><?php echo ucfirst($user->username); ?></td>
                      </tr>
                      <tr>
                        <td>Register date:</td>
                        <td><?php echo Users_gen::convert_date($user->register_date); ?></td>
                      </tr>
                      <tr>
                        <td>Date of Birth:</td>
                        <td><?php echo $user->born_date; ?></td>
                      </tr>
                         <tr>
                             <tr>
                        <td>Gender:</td>
                        <td><?php echo ucfirst($user->user_gender); ?></td>
                      </tr>
                        <tr>
                        <td>Home Address:</td>
                        <td><?php echo $user->user_address; ?></td>
                      </tr>
                      <tr>
                        <td>Email:</td>
                        <td><a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></td>
                      </tr>
					   <tr>
                        <td>User status:</td>
                        <td><?php echo Users_status::get_user_status($user->user_status); ?><input type="hidden" id="user-status" value="<?php echo Users_status::get_user_status($user->user_status); ?>"></td>
                      </tr>
                        <td>Phone Number:</td>
                        <td><?php echo $user->phone_number; ?></td>
                      </tr>
                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
                 <div class="panel-footer">
					<?php
						/*if( ($this->username != null) && ($this->username == $user->username) ){
							?>
								<a data-original-title="Send Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>	
							<?php
						}*/
					?>
                        
							<span class="pull-right">
							
							<?php
							if(Users::is_admin2($this->user_id) || Users::is_moderator($this->user_id)){
								
								if($this->username == null || $this->username == $checkUser){
									?>
									<a href="user/edit/<?php echo $user->username; ?>" data-original-title="Edit profil" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
									<?php
								}else{
									?>
									<a href="user/edit/<?php echo $user->username; ?>" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
									<?php
								}

							}else if($this->username == null){
								?>
								<a href="user/edit/<?php echo $user->username; ?>" data-original-title="Edit profil" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
								<?php
							}else if($this->username == $checkUser){
								?>
								<a href="user/edit/<?php echo $user->username; ?>" data-original-title="Edit profil" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
								<?php
							}
							
						if(Users::is_admin2($this->user_id) || Users::is_moderator($this->user_id)){; ?>
                            <a id="delete_user" data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                        </span>
						<?php }; ?>
                        
                    </div>
            
          </div>
        </div>
      </div>
   



<script>
$(document).ready(function() {
	var user_status = $("#user-status").val();
	var user_name = $("#user-name");
	

	if(user_status == "Inactive"){
		user_name.css({"background":"red"});
	}
	
	
    var panels = $('.user-infos');
    var panelsButton = $('.dropdown-user');
    panels.hide();

    //Click dropdown
    panelsButton.click(function() {
        //get data-for attribute
        var dataFor = $(this).attr('data-for');
        var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function() {
            //Completed slidetoggle
            if(idFor.is(':visible'))
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
            }
            else
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
            }
        })
    });


    $('[data-toggle="tooltip"]').tooltip();
	
	
	$("#delete_user").click(function(){
		var user_id = $("#usrid").val();
		if(confirm("Delete this user?")){
			$.ajax({
				url: 'user/delete_user',
				type: 'post',
				data: {'user_id':user_id},
				success: function(msg){
					$("#message").html(msg);
					show_modal();
				}
			});
		}
	});
	
	
	
		
	
	

});


</script>


<?php
SiteFunc::master_footer();
?>