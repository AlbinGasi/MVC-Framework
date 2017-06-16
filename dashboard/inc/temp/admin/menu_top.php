<?php
$siteHASH = Config::get('hash_key');
$ch_user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
?>
<body>
<div id="wrapper">
<!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index">Admin panel </a>
                <a target="_blank" class="navbar-brand" href="<?php echo Config::get('url_site') ?>"><i class="fa fa-external-link" aria-hidden="true"></i> </a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <!--li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>test 01</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>test 02</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i>  Users<b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li>
                            <a href="user/"> All users</a>
						</li>
					<?php 
							if(Admin::can_view_2()){
									?>
								<li>
									<a href="user/blockeduser"> Blocked users</a>
							</li>
						<li>
							<a href="user/adminuser"> Administrators</a>
						</li>
						<li>
							<a href="user/moderatoruser"> Moderators</a>
						</li>
				<?php
								}
							?>
                       
						<?php 
							if(Admin::can_view()){
									?>
						<li>
							<a href="user/writeruser"> Writers</a>
						</li>
						<?php
							}
							?>
                    </ul>
                </li>
                <li class="dropdown">
				<?php 
					$first_name = Users_gen::get_fname($_SESSION[$siteHASH]['user_id']);
					
				?>
				
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $first_name; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="user/profil"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <!--li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li-->
                        <li>
                            <a href="user/edit"><i class="fa fa-fw fa-gear"></i> Edit</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <button class="btn btn-default btn-block" type="button" id="logout_send"><i class="fa fa-fw fa-power-off"></i> Log Out</button>
                        </li>
                    </ul>
                </li>
            </ul>
<div id="info" class="modal_cus">
  <!-- Modal content -->
  <div class="modal_cus-content">
  <div class="modal-header-reg">Logout</div>
    <div class="close_cus">x</div>
	<div class="modal-content-msg">
	<div id="info_msg">
		
	</div>
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

var modal_logout = $("#info");
var close_logout = $(".close_cus");

close_logout.click(function(){
	modal_logout.css("display","none");
});

function show_modal_logout(){
	modal_logout.fadeIn(250,function(){
	});

}	
				$(function(){
					$("#logout_send").click(function(){
						var id = "2";
						$.ajax({
							url: 'user/logout',
							type:'post',
							data: {'id':id},
							success: function(msg){
								$("#info_msg").html(msg);
								show_modal_logout();
								setTimeout(function(){
									window.location.reload();
								}, 1500);
							}
							
						});
					});
				});
			
			</script>
			
			
			
			
			
			