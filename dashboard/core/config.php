<?php
		$GLOBALS["iwconfig"] = array(
				"DB" => array(
						"host" => "",
						"user" => "",
						"password" => "",
						"db_name" => ""
				),
				
				"table_prefix" => "",
				
				"image_dir" => "public/img-media/",
				"gallery_dir" => "public/post-gallery/",
				
				"paginator_all_posts" => 10,
				"paginator_all_posts_category" => 10,
				"paginator_all_posts_of_categories" => 10,

				"path" => "/testing/dashboard/", // path to your folder from root
				"full_path" => "http://localhost/testing/dashboard/", //full url link to your admin panel
				"folder_name" => "dashboard", // your folder name
				"url_site" => "http://localhost/testing/", // link from your site http://www.yoursite.com/ 
				"url_news" => "http://localhost/testing/blog", // this is link or page where you want to show your news
				"hash_key" => 'ffggttsad3434',

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
?>