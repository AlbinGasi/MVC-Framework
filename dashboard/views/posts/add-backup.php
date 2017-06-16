<?php
SiteFunc::master_header("New Post -> Posts","Add Post","<li><a href='posts/'>Posts</a></li><li>Add post</li>");
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
							<strong>Successful</strong> Your post has been published.
						</div>
					
							<script>
								$(function(){
									$(document).on("click","#admin-view",function(){
										$(".modal-body-view").load("posts/admin_view");
										$('#post-view').modal('show');
									});
										
								});
								 </script>
					
					</div>
					<div class="modal-footer">
					<button id="admin-view" type="button" class="btn btn-info" data-dismiss="modal">View your post</button>
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- // Modal END -->
			  
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
<p class="help-block">Enter title of your news.</p>
</div>

<div class="form-group">
	<label>Introduction</label>
	<textarea class="form-control" rows="3" name="introduction"></textarea>
	<p class="help-block">A few words of introduction.</p>
</div>

<div class="form-group">
    <label>Featured picture</label>
    <input type="file" name="image">
	<p class="help-block"><strong><em>If you want! </em></strong>Choose a featured picture for your post.</p>
</div>

<div class="form-group">
    <label>Enter your news</label>
    <textarea class="form-control" rows="20" name="news"></textarea>
                            </div>
                       

</div>
<div class="col-lg-3">
<h3></h3>
<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Category</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
								<?php 
								$categories = Categories::get_all();
								foreach($categories as $k => $v){
									echo "<div class='checkbox'>";
									echo "<label>";
									echo "<input type='checkbox' name='category[]' value=".$v['category_name'].">".ucfirst($v[	'category_name']);
									echo "</label>";
									echo "</div>";
								}
								?>
								<p class="help-block">Select categories for your post.</p>
                            </div>
                            </div>
                        </div>
						
<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Type</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
								<?php
								
								$post_type = Posts::post_type(); //arr								
								foreach($post_type as $pt_status){
									echo '<div class="radio">';
									echo '<label>';
									echo '<input type="radio" name="post-type" value="'.$pt_status.'">'.ucfirst($pt_status);
									echo '</label>';
									echo '</div>';
								}
								?>
								<p class="help-block">Is these post important than lasts, select type for your post.</p>
                            </div>
                            </div>
                        </div>
						
<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Comment status</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
							
							<?php
								
								$comment_status = Posts::comment_status(); //arr
								foreach($comment_status as $c_status){
									echo '<div class="radio">';
									echo '<label>';
									echo '<input type="radio" name="comment-status" value="'.$c_status.'">'.ucfirst($c_status);
									echo '</label>';
									echo '</div>';
								}
								?>
								<p class="help-block">Allow or disable comment for this post.</p>
                            </div>
                            </div>
                        </div>
						
<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Post status</h3>
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
								
							
                                
								<p class="help-block">You can publish your post now or save to draft for later</p>
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
	$author = "admin";
	$post_id = Posts_insert::last_post_id();

	$post = new Posts_insert;
	$post->post_title = strip_tags(trim($_POST['title']));
	$post->post_introduction = htmlentities(trim($_POST['introduction']));
	$post->post_image = (!empty($_FILES['image']['name'])) ? Posts_image::get_image_new_name($_FILES['image']['name'],$_FILES['image']['type']): "none";
	$post->post_content = htmlentities(trim($_POST['news']));
	$post->post_category = (isset($_POST['category'])) ? Posts_insert::implode_categories_name($_POST['category']) : "";
	$post->post_type = (isset($_POST['post-type'])) ? strip_tags(trim($_POST['post-type'])) : "post";
	$post->comment_status = (isset($_POST['comment-status'])) ? strip_tags(trim($_POST['comment-status'])) : "open";
	$post->post_status = (isset($_POST['post-status'])) ? strip_tags(trim($_POST['post-status'])) : "publish";
	$post->post_author = strip_tags(trim($author));

	
	if(Validation::post_validation($post->post_title,$post->post_introduction,$post->post_content,$post->post_category,$post->post_type,$post->comment_status,$post->post_status,$post->post_author)){

		if(!empty($_FILES['image']['type'])){
			if(Validation::post_image_validation($_FILES['image']['type'],$_FILES['image']['size'])){
				$post->insert();
				Categories::insert_mulitple_categories($post_id,$_POST['category']);	
				
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
			$post->insert();
			Categories::insert_mulitple_categories($post_id,$_POST['category']);
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



















