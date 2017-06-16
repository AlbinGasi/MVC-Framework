<?php

if(isset($_POST['boothu'])){
	if($_POST['boothu'] == "Tx7tRj5b0VAG"){
		$host = $_POST['host'];
		$user = $_POST['user'];
		$password = $_POST['password'];
		$dbname = $_POST['dbname'];

		$tblprefix = $_POST['tblprefix'];
		
		$weburl = $_POST['weburl'];
		$newsurl = $_POST['newsurl'];
		$foldername = $_POST['foldername'];
		$cmsurl = $_POST['cmsurl'];
		$cmspath = $_POST['cmspath'];
		
		$hash_key = uniqid();
		
		
		
		if(file_exists("../../core/config.php")){
	 $file = fopen('../../core/config.php','w');
	 $txt = '<?php
		$GLOBALS["iwconfig"] = array(
				"DB" => array(
						"host" => "'.$host.'",
						"user" => "'.$user.'",
						"password" => "'.$password.'",
						"db_name" => "'.$dbname.'"
				),
				
				"table_prefix" => "'.$tblprefix.'",
				
				"image_dir" => "public/img-media/",
				"gallery_dir" => "public/post-gallery/",
				
				"paginator_all_posts" => 10,
				"paginator_all_posts_category" => 10,
				"paginator_all_posts_of_categories" => 10,

				"path" => "'.$cmspath.'", // path to your folder from root
				"full_path" => "'.$cmsurl.'", //full url link to your admin panel
				"folder_name" => "'.$foldername.'", // your folder name
				"url_site" => "'.$weburl.'", // link from your site http://www.yoursite.com/ 
				"url_news" => "'.$newsurl.'", // this is link or page where you want to show your news
				"hash_key" => "'.$hash_key.'",

				"ADMIN" => array(
						"pagination_path" => "posts/all/",
						"pagination_useractivity_limit" => 50,
						"pagination_limit" => 20,
						"pagination_gallery_post_limit" => 20,
						"pagination_comments_limit" => 20,
						"pagination_gallery_limit" => 50,
						"controller_get_name" => "url"
				),
		);
?>';
		 if(fwrite($file,$txt)){
		 echo "<span id='finmsg22'>All done! You will be redirect now...</span>";
	 }else{
		  echo "<span id='finmsg22'>Ther's some error, please configurate manual a config file in your core folder.</span>";
	 }
	}
}

	 
	 

	 
	
}


?>