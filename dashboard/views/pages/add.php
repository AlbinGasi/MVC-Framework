<?php
SiteFunc::master_header("New Post -> Posts","Add Post","<li><a href='posts/'>Posts</a></li><li>Add post</li>");

if(!Admin::can_view()){
	Alerts::get_alert("danger","You can't access to this area.");
	SiteFunc::master_footer();
	return false;
}

?>

			   <!-- Modal -->
			  <div class="modal fade" id="post-view" role="dialog">
				<div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
					<div class="modal-body" style="padding: 0;">
						<div class="modal-body-view">
						
						</div>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- //  Modal END -->
			  

<div class="row">
<form role="form" action="" method="POST" enctype="multipart/form-data">
<div class="col-lg-9">
<div class="form-group">
<label>Title</label>
<input class="form-control" name="title">
<p class="help-block">Enter title of your page.</p>
</div>

<div class="form-group">
    <label>Featured picture</label>
    <input type="file" name="image">
	<p class="help-block"><strong><em>If you want! </em></strong>Choose a featured picture for your page.</p>
</div>

 <button id="add-more-picture" type="button" class="btn btn-primary">Add gallery</button><br><br>

 <div id="gallery-post-image">

</div>
 
 
<script>
	$(function(){
		$(document).on("click","#add-more-picture",function(){
			$("#gallery-post-image").append('<div class="panel panel-green"><div class="panel-heading"><h3 class="panel-title">Add picture gallery</h3> ( for multiple upload - hold down key ctrl and select files)</div><div class="panel-body"><div id="input-area-gallery"><input type="file" name="gallery[]" multiple="multiple"></div></div></div>');
			$(this).attr("id","remove-more-picture");
			$(this).attr("class","btn btn-default");
			$(this).html("Remove gallery");
		});
		
		$(document).on("click","#remove-more-picture",function(){
			$("#gallery-post-image div").fadeOut(500,function(){
				$(this).remove();
			});
			$(this).attr("id","add-more-picture");
			$(this).attr("class","btn btn-primary");
			$(this).html("Add gallery");
		});
	});
</script>
 

<div class="form-group">
    <label>Content</label>
    <textarea class="form-control textarea-c" rows="20" name="news"></textarea>
                            </div>
                       

</div>
<div class="col-lg-3">
<h3></h3>


						
<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Page status</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
							
								<?php
								
								$post_status = Posts::post_status(); //arr
								foreach($post_status as $p_status){
									echo '<div class="radio">';
									echo '<label>';
									echo '<input type="radio" name="post-status" value="'.$p_status.'">'.ucfirst($p_status);
									echo '</label>';
									echo '</div>';
								}
								?>
								
							
                                
								<p class="help-block">You can publish your page now or save to draft for later</p>
                            </div>
                            </div>
                        </div>

						
<button type="submit" name="btn_submit" class="btn btn-primary">Publish</button>
<button type="reset" class="btn btn-default">Reset</button>               
</div>
</form>
</div>
<br><br>


<?php
if(isset($_POST['btn_submit'])){
	$user_id = (isset($_SESSION['user_ag']['user_id'])) ? $_SESSION['user_ag']['user_id'] : -122;

	$author = Users::get_by_id($user_id);
	$post_id = Posts_insert::last_post_id();

	$post = new Posts_insert;
	$post->post_title = strip_tags(trim($_POST['title']));
	
	$newName = strip_tags(trim($_POST['title']));
	$post->post_name = $post->setPostName($newName);
	
	$post->post_introduction = '';
	$post->post_image = (!empty($_FILES['image']['name'])) ? Posts_image::get_image_new_name($_FILES['image']['name'],$_FILES['image']['type']): "none";
	$post->post_content = htmlentities(trim($_POST['news']));
	$post->post_category = (isset($_POST['category'])) ? strip_tags(trim($_POST['category'])) : "page";
	$post->post_type = (isset($_POST['post-type'])) ? strip_tags(trim($_POST['post-type'])) : "page";
	$post->comment_status = 'closed';
	$post->post_status = (isset($_POST['post-status'])) ? strip_tags(trim($_POST['post-status'])) : "publish";
	$post->post_author = strip_tags(trim($author->username));
	
	if(Validation::post_validation($post->post_title,$post->post_introduction,$post->post_content,$post->post_category,$post->post_type,$post->comment_status,$post->post_status,$post->post_author)){

		if(!empty($_FILES['image']['type'])){
			if(Validation::post_image_validation($_FILES['image']['type'],$_FILES['image']['size'])){
				
				if(isset($_FILES['gallery']['name'])){
				$post_gallery = new Posts_gallery;
				$post_gallery->create_post_gallery();
				Users::setUserActivity($author->username, "Added a new gallery",$post_id);
			}
			Users::setUserActivity($author->username, "Added a new post",$post_id);
			$post->insert_post($post->post_title,$post->post_name,$post->post_introduction,$post->post_image,$post->post_content,$post->post_category,$post->post_type,$post->comment_status,$post->post_status,$post->post_author,$_POST['category']);
				
				$post_image = new Posts_image;
				$post_image->insert_image($_FILES['image']['tmp_name'],$post->post_image);
				?>
				<script>
				$(function(){
					$("#succesfulModal").modal("show")
				});
				</script>
			<?php
			}else{
				?>
				<script>
				$(function(){
					$("#validationError").modal("show")
				});
				</script> 
				<?php
			}
		}else{
			
			if(isset($_FILES['gallery']['name'])){
				$post_gallery = new Posts_gallery;
				$post_gallery->create_post_gallery();
				Users::setUserActivity($author->username, "Added a new gallery",$post_id);
			}
Users::setUserActivity($author->username, "Added a new post",$post_id);
$post->insert_post($post->post_title,$post->post_name,$post->post_introduction,$post->post_image,$post->post_content,$post->post_category,$post->post_type,$post->comment_status,$post->post_status,$post->post_author,$_POST['category']);

			 ?>
			 <script>
				$(function(){
					$("#succesfulModal").modal("show")
				});
				</script> 
			 
			 <?php
				
			
		}	
	}else{
						?>
				<script>
				$(function(){
					$("#validationError").modal("show")
				});
				</script> 
				<?php
	}
	

	
	


}


SiteFunc::master_footer();
?>
<!-- Modal -->
			  <div class="modal fade" id="succesfulModal" role="dialog">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Successful</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-success">
							<strong>Successful</strong> Your post has been updated.
						</div>
						<?php $post_gallery = new Posts_gallery; $post_gallery->get_information(); ?>
						<?php $post_gallery->get_error_gallery(); ?>
						<span id="3322" class="apv-id"></span>
							<script>
								$(function(){
									$(document).on("click","#admin-view",function(){
										var id_el = $(".apv-id").attr("id");
										
										$.ajax({
											url: 'posts/admin_view/',
											type: 'post',
											data: {'ide':id_el},
											success: function(feedback_view){
												$(".modal-body-view").html(feedback_view);
												$('#post-view').modal('show');
											}
										});
									});
								});
								 </script>
					
					</div>
					<div class="modal-footer">
					<button id="admin-view" type="button" class="btn btn-info" data-dismiss="modal">View your post</button>
					  <button id="close-post-success" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- // Modal END -->

 <!-- Modal -->
			  <div class="modal fade" id="validationError" role="dialog">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Error</h4>
					</div>
					<div class="modal-body">
						<?php Validation::get_error(); ?>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- // Modal END -->



















