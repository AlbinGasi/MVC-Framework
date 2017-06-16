<?php
SiteFunc::master_header("All Users","All users","<li><a href='user/'>User</a></li><li>All Users</li>");
$this->user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;

$checkEmailValidation = Users_gen::get_not_valdiate_user();
$deletedUsers = Users_gen::get_deleted_user();
?>

<button class="btn btn-primary" type="button">
Check for email validation <span class="badge"><?php echo $checkEmailValidation; ?></span>
</button>
<button class="btn btn-danger" type="button">
Deleted users <span class="badge"><?php echo $deletedUsers; ?></span>
</button>


<br><br>
 <div class="clearfix"></div>

<?php
$all_users = Users_gen::all_users();

foreach($all_users as $user){
	
		if($user['user_status'] == 0){
		if(Admin::can_view_2()){
			$output = "";
			$output .= '<a href="user/profil/'.$user['username'].'" class="ag_userlink">';
			$output .= '<div class="ag_wrapper">';
			$output .= '<div class="ag_header_block">'.ucfirst($user['first_name']). " " . ucfirst($user['last_name']).'</div>';
			$output .= '<div class="ag_userdetail">';
			$output .= '<span class="ag_txt"><b>Username: </b>'.ucfirst($user['username']).'</span>';
			$output .= '<span class="ag_txt"><b>Birth: </b>'.$user['born_date'].'</span>';
			$output .= '<span class="ag_txt"><b>Gender: </b>'.ucfirst($user['user_gender']).'</span>';
			$output .= '<span class="ag_txt"><b>Status: </b>'.Users_status::get_user_status($user['user_status']).'</span>';
			$output .= '<div class="ag_footer_block"></div>';
			$output .= '</div></div></a>';
			echo $output;	
		}else{
			continue;
		}
	}else{
		
		if($user['user_status'] == 1){
			if(!Admin::can_view_2()){
				continue;
			}
		}
		
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
}



?>



 
<?php
SiteFunc::master_footer();
?>