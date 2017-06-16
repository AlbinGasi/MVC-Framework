<?php
use lib\models\Config;

include_once Config::DASHBOARD_NAME.'/show_news_classic.php';

if($content->post_image == 'none'){
	$has_image = false;
}else{
	$has_image = true;
	$page_image = Config::DASHBOARD_URL . '/public/img-media/' . $content->post_image;
}
/*
	What is this?
	This page will be automatically loaded on your page if in your database exist

	you can use next variables:
	- echo $content->post_title;  // your page title
	- echo htmlspecialchars_decode($content->post_content); // page content
	- echo $content->post_author; // page author
	- echo $content->post_date2; // page date
	- echo $page_image; // this variable will return link from your featured image

	you can stylize whatever you want
	gallery will be automatically added if exist
 */
 ?>
<?php

echo '<h2>'.$content->post_title . '</h2>';

if($has_image === true){
	echo '<img src="'.$page_image.'" style="max-width:400px;">';
}

$iw_news->get_pageGallery($content,$iw_news);

echo htmlspecialchars_decode($content->post_content);




?>