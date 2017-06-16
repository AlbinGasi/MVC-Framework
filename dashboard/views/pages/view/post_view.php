<?php
SiteFunc::master_header("Post view","View post","<li><a href='posts/post_view'>Post view</a></li><li>View post</li>");
$id = $this->id;

if(!Posts_edit::check_post_for_edtit($this->id)){
	Alerts::get_alert("danger","Error!","Post not found!");
	SiteFunc::master_footer();
	return false;
}
$post_view = Posts_view::get_by_id($id);
?>
<div class="admin-view-post">

<div class="panel panel-default" style="border:0px solid #fff;margin:0px;">
<div style="position:relative;" class="panel-heading"><h3><?php echo $post_view->post_title; ?></h3>

<?php 
	if(Admin::admin_moderator_author($post_view->post_author)){
		?>
		<a style="position:absolute;top:5px;right:5px;" href="posts/edit/<?php echo $post_view->post_id ?>" class="btn btn-info" role="button">Edit</a>
		<?php
	}
?>

</div>

 <div class="panel-body">




<div class="post-about">
<div class="author"><strong>By: </strong><span><?php echo ucfirst($post_view->post_author); ?></span></div>
<div class="date"><strong>Date: </strong><span><?php echo $post_view->get_post_date($id); ?> at <?php echo $post_view->get_post_time($id); ?></span></div>
</div>
<div class="post-introduction">
<?php echo html_entity_decode($post_view->post_introduction); ?>

</div>

<?php
if($post_view->post_image === "none"){
}else{
 ?>
<div class="post-image">
<img src="<?php echo Config::get("image_dir").$post_view->post_image; ?>" width="400">
</div>
<?php } ?>

<?php
if(Posts_gallery::gallery_set($id)){
$gallery = Posts_gallery::get_gallery_image_name($id);
$gallery_path = Config::get("gallery_dir");
echo '<input type="hidden" name="gallery-path" value="'.$gallery_path.'">';
echo '<input type="hidden" id="post_id_val" value="'.$id.'">';
$scandir = array_diff(scandir($gallery_path), array('..', '.'));
?>
<div id="your-gallery">

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
echo '</div></div></div>';
}
?>


<div class="post-content">
<?php echo html_entity_decode($post_view->post_content);  ?>
</div>

<?php
echo Comments::show_comments_of_post($id);
?>


</div>
</div>
</div>
<?php
SiteFunc::master_footer();
?>