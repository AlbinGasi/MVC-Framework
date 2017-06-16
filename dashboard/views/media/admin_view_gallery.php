<style>
.admin-view-post{
	margin: 0 auto;
	width: 100%;
	word-wrap: break-word;
}

.post-title{
	color: #333;
	font-size: 18px;
	font-weight: bold;
	font-family: Tahoma;
	background: #DDD;
	padding: 5px;
	border-radius: 3px;
	margin-bottom: 4px;
}
.post-introduction{
	font-size:18px;
	font-family: Vedrana;
	letter-spacing: 0.6px;
	margin-bottom: 5px;
}
.post-image{
	margin-bottom:5px;
}

.post-image img{
	border:2px solid #DDD;
	border-radius: 5px;
}
.post-image img:hover{
	opacity: 0.7;
}

.post-content{
	font-family: Arial;
	font-size: 15px;
	letter-spacing: 0.8px;
}

.post-about{
	clear: both;
	margin-bottom: 20px;
	border-bottom: 2px solid #EEE;
	position: relative;
	#background: #EEE;
	height: 27px;
	padding: 5px;
}

.post-about .author{
	position: absolute;
	left: 4px;
}
.post-about .date{
	position: absolute;
	right:4px;
}

</style>

<?php

if(isset($_POST['id'])){
	$id = trim(strip_tags($_POST['id']));
	$post_view = Posts_view::get_by_id($id);
	
	?>
	
<div class="admin-view-post">

<div class="panel panel-default" style="border:0px solid #fff;margin:0px;">
<div class="panel-heading"><h3><?php echo $post_view->post_title; ?></h3></div>

 <div class="panel-body">




<div class="post-about">
<div class="author"><strong>By: </strong><span><?php echo ucfirst($post_view->post_author); ?></span></div>
<div class="date"><strong>Date: </strong><span><?php echo $post_view->get_post_date($id); ?> at <?php echo $post_view->get_post_time($id); ?></span></div>
</div>



<?php
if(Posts_gallery::gallery_set($id)){
$gallery = Posts_gallery::get_gallery_image_name($id);
$gallery_path = Config::get("gallery_dir");
echo '<input type="hidden" name="gallery-path" value="'.$gallery_path.'">';
echo '<input type="hidden" id="post_id_val" value="'.$id.'">';
$scandir = array_diff(scandir($gallery_path), array('..', '.'));
?>
<div id="your-gallery">
		<div class="panel panel-green">
			<div class="panel-heading">
				<h3 class="panel-title">Gallery</h3></div>
			<div class="panel-body">

<div id="img-c-nn">
<div id="img-c-n">
<?php
foreach($gallery as $i => $v){
	//if(in_array($v['gallery_value'],$scandir)){
		$alt = Posts_image::get_image_name_library($v['gallery_value']);
		?>
			<div id="<?php echo $v['gallery_value']; ?>" class="img-gallery" style="display:inline;position:relative;"><img style="border:1px solid #DDD;border-radius:4px; margin-right:4px;margin-top:8px;padding:4px" class="post-gallery-image" src="<?php echo $gallery_path.$v['gallery_value'];?>"  width="165" height="165" title="<?php echo $alt; ?>" alt="<?php echo $alt; ?>"></div>
		<?php
	//}
}
echo '</div></div></div></div></div>';
}
?>


</div>
</div>
</div>
	

<?php
}
?>