<?php
SiteFunc::master_header("Admin Users","Admin users","<li><a href='user/'>User</a></li><li>Admin</li>");
$this->user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;

if(Admin::can_view_2()){
$blocked_users = Admin::get_users(350,351);
foreach($blocked_users as $user){
			$output = "";
			$output .= '<a href="user/profil/'.$user['username'].'" class="ag_userlink">';
			$output .= '<div class="ag_wrapper">';
			$output .= '<div class="ag_header">'.ucfirst($user['first_name']). " " . ucfirst($user['last_name']).'</div>';
			$output .= '<div class="ag_userdetail">';
			$output .= '<span class="ag_txt"><b>Username: </b>'.ucfirst($user['username']).'</span>';
			$output .= '<span class="ag_txt"><b>Birth: </b>'.$user['born_date'].'</span>';
			$output .= '<span class="ag_txt"><b>Gender: </b>'.ucfirst($user['user_gender']).'</span>';
			$output .= '<span class="ag_txt"><b>Status: </b>'.Users_status::get_user_status($user['user_status']).'</span>';
			$output .= '<div class="ag_footer"></div>';
			$output .= '</div></div></a>';
			echo $output;	
}
}else{
	Alerts::get_alert("danger","Error!"," You don't have a privilegies");
}


?>



 
<?php
SiteFunc::master_footer();
?>