<?php

$page_number = (isset($_POST['page'])) ? $_POST['page'] : 1;


$gallery_path = Config::get("gallery_dir");
echo '<input type="hidden" name="gallery-path" value="'.$gallery_path.'">';
$scandir = array_diff(scandir($gallery_path), array('..', '.'));

if(empty($scandir)){
	Alerts::get_alert("info","You don't have any image in your library.");
	return false;
}

$get_library = Media_gallery::get_library($page_number);
foreach($get_library as $img => $v){
	$alt = Posts_image::get_image_name_library($v['gallery_value']);
	echo '<div id="'.$v['gallery_value'].'" data-model="'.$alt.'" class="img-gallery" style="display:inline;position:relative;"><img style="border:1px solid #DDD;border-radius:4px; margin-right:4px;margin-top:8px;padding:4px" class="post-gallery-image" src="'.$gallery_path.$v['gallery_value'].'"  width="165" height="165" alt="'.$alt.'" title="'.$alt.'"></div>';
}
?>