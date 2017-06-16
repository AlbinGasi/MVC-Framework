<?php
SiteFunc::master_header("Edit Page -> Pages","Edit page","<li><a href='pages/'>Pages</a></li><li>Edit page</li>");

if(empty($this->id)){
	echo '<div class="alert alert-danger">
                    <strong>Sorry!</strong> Your request is invalid.
                </div>';
	SiteFunc::master_footer();
	return false;
}else if(!is_numeric($this->id)){
	echo '<div class="alert alert-danger">
                    <strong>Sorry!</strong> Your request is invalid.
                </div>';
	SiteFunc::master_footer();
	return false;
}

echo "<input type='hidden' id='prtOfId' value='".$this->id."'>";

$get_post_username = Posts_edit::get_by_id($this->id);
$get_user_username = Users::get_by_id(Admin::get_user_id());

 if(Admin::can_view_2()){
	 
 }else if($get_post_username->post_author != $get_user_username->username){
	 Alerts::get_alert("danger","Error!","You can't edit this page.");
	 SiteFunc::master_footer();
	 return false;
}

if(!Posts_edit::check_post_for_edtit($this->id)){
	 Alerts::get_alert("danger","Error!"," Page not found!");
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
					  <button id="close-post-success" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- //  Modal END -->
	  
			  


<?php
$recover_photo = Posts_image::get_post_image_name($this->id);
$category_for_post = Categories::get_category_for_post($this->id);
$post_category = "";
foreach($category_for_post as $k => $v){
	$post_category .= $v['category_name'] . "|";
}
$post_category = explode("|",$post_category);

$post = Posts_edit::get_by_id($this->id);
?>




<div class="row">
<form role="form" action="" method="POST" enctype="multipart/form-data">
<div class="col-lg-9">
<div class="form-group">

<label>Title</label>
<input class="form-control" name="title" value="<?php echo $post->post_title; ?>">
<p class="help-block">Enter title of your page.</p>
</div>

<div class="form-group">
    <label>Featured picture</label>
			  
<input id="photo-name" type="hidden" value="<?php echo $recover_photo ?>">
<input id="image-dir" type="hidden" value="<?php echo Config::get("image_dir"); ?>">

<div id="button-edit-photo"></div>

<script>
	
	$(function(){
		
		function get_image_name(photo_name){
			photo_name = photo_name.split(".");
			image_name_new = photo_name[0];
			return image_name_new;
		}
	
		$(document).on("click","#change-photo",function(){
			$("#featured-image-edit img").fadeOut(450,function(){
				$(this).remove();
			});
			$("#featured-image-edit").html("<input type='file' name='image'>");
			$("#button-edit-photo").html('<button id="recover-photo" type="button" class="btn btn-default">Recover old photo</button></div><br>');
			
			$("#featured-image-edit").append('<br><p class="help-block"><strong><em>If you want! </em></strong>Choose a featured picture for your post. <br><strong>If you leave blank</strong>, your previous image will be deleted.</p>');
			$(this).remove();

		});
		
		$(document).on("click","#recover-photo",function(){
			var photo_name = $("#photo-name").val();
			var image_dir = $("#image-dir").val();
			var split_name = get_image_name(photo_name);
			$("#featured-image-edit").html("<img src="+image_dir+photo_name+" title='' alt="+split_name+" width='400'>");
			$("#featured-image-edit").append('<p class="help-block">This is your featured image</p>');
			$("#button-edit-photo").html('<button id="change-photo" type="button" class="btn btn-primary">Change photo</button><br>');
		});
		
		
		
		
		
	});
	
	
</script>
	
	
	<?php  
		
		if(Posts_image::image_set($this->id)){
			echo '<div id="button-edit-photo"><button id="change-photo" type="button" class="btn btn-primary">Change photo</button></div><br>';
			echo '<div id="featured-image-edit">';
			Posts_image::show_image($this->id);
			echo '<p class="help-block">This is your featured image</p>';
			echo "</div>";
			
		}else{
			echo '<input type="file" name="image">';
			echo '<p class="help-block"><strong><em>If you want! </em></strong>Choose a featured picture for your post.</p>';
		}
	
	?>
	
   
	
</div>
<div id="panel-delete-images" style="display:none" class="panel panel-red">
	<div class="panel-heading">
		<h3 class="panel-title">Images for delete</h3>
	</div>
	<div class="panel-body">
		<div id="images-for-delete">
				
		</div>
	</div>
	<div class="panel-footer">
		<button id="delete-selected-images" type="button" class="btn btn-danger">Delete selected images</button>
		<span></span>
		
	</div>
</div>
<?php
if(Posts_gallery::gallery_set($this->id)){
$gallery = Posts_gallery::get_gallery_image_name($this->id);
$gallery_path = Config::get("gallery_dir");
echo '<input type="hidden" name="gallery-path" value="'.$gallery_path.'">';
$scandir = array_diff(scandir($gallery_path), array('..', '.'));
?>
<div id="your-gallery">
		<div class="panel panel-green">
			<div class="panel-heading">
			<button style="float:right;" id="remove-gallery" type="button" class="btn btn-default">Remove gallery</button>
				<h3 class="panel-title">Update your gallery</h3>( for multiple upload - hold down key ctrl and select files)
			</div>
			<div class="panel-body">
				<div id="input-area-gallery">
					<input type="file" name="gallery[]" multiple="multiple">
				</div>

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
?>

<script>
	$(function(){
		$(document).on("click","#remove-gallery",function(){	
		if(confirm("Delete all images in this gallery?")){
			var num = $("#img-c-n .img-gallery").length;
			var ggg = $("#prtOfId").val();
			
			if(num==0){
				photo_for_delete = "none";
			}else{
				var img_name = $(".img-gallery").map(function(){
					return $(this).attr("id");
				}).get();
				
				photo_for_delete = img_name.join().replace(/,/g, '|');
			}
				
				$.ajax({
				url: 'media/delete',
				type: 'post',
				data: {'names':photo_for_delete,'postID':ggg},
				success: function(msg){
					$("#img-c-n").html(msg);
				}
			});
		}else{
			return false;
		}
				
		});
		
		$(document).on("mouseenter",".img-gallery",function(){
			var btn = '<div id="btn-delete" style="display:inline;position:absolute;right:0px;top:-70px"><button style="width:20px;height:20px;padding:0px;" type="button" class="btn btn-primary"><i class="fa fa-fw fa-trash-o"></i></button></div>';
		$(this).append(btn);
		});
	
		$(document).on("mouseleave",".img-gallery",function(){
			$("#btn-delete").remove();
		});
		
		$(document).on("mouseenter",".img-gallery2",function(){
		var btn = '<div id="btn-delete2" style="display:inline;position:absolute;right:0px;top:-10px"><button style="width:20px;height:20px;padding:0px;" type="button" class="btn btn-primary"><i class="fa fa-fw fa-trash-o"></i></button></div>';
		$(this).append(btn);
	});
	
		$(document).on("mouseleave",".img-gallery2",function(){
			$("#btn-delete2").remove();
		});
		
		$(document).on("click","#btn-delete2",function(){
			var img_name = $(this).parent(".img-gallery2").attr("id");
			var gallery_dir = $("input[name='gallery-path']").val();
			var r_alt = img_name.split("_");
			alt = r_alt[0];
			
			$("#img-c-n").prepend('<div id="'+img_name+'" class="img-gallery" style="display:inline;position:relative;"><img style="border:1px solid #DDD;border-radius:4px; margin-right:4px;margin-top:8px;padding:4px" class="post-gallery-image" src="'+gallery_dir+img_name+'" width="165" height="165" title="'+alt+'" alt="'+alt+'"></div>');
			
			$(this).parent().fadeOut(100,function(){
				$(this).remove();
			});
			
			var num = $("#images-for-delete .img-gallery2").length;
			if(num==1){
				$("#images-for-delete").html("");
				$("#panel-delete-images").hide(800);
			}
		});
		
		
		$(document).on("click","#btn-delete",function(){
		var photo_name = $(this).parent().attr("id");
		var gallery_path = $("input[name='gallery-path']").val();
		
		$("#panel-delete-images").show(800);
		$("#images-for-delete").append('<div id="'+photo_name+'" class="img-gallery2" style="display:inline;position:relative;"><img style="border:1px solid #DDD;border-radius:4px; margin-right:4px;margin-top:8px;padding:4px" class="post-gallery-image" src="'+gallery_path+photo_name+'" width="50" height="50"></div>');
		

		$(this).parent().fadeOut(200,function(){
			$(this).remove();
		});
	});
	
	$(document).on("click","#delete-selected-images",function(){
			var num = $("#images-for-delete .img-gallery2").length;
			var ggg = $("#prtOfId").val();
			
			if(num==0){
				photo_for_delete = "none";
			}else{
				var img_name = $(".img-gallery2").map(function(){
					return $(this).attr("id");
				}).get();
				
				photo_for_delete = img_name.join().replace(/,/g, '|');
			}
			
			$.ajax({
				url: 'media/delete',
				type: 'post',
				data: {'names':photo_for_delete,'postID':ggg},
				success: function(msg){
					$("#images-for-delete").html(msg);
				}
			});
			
			$("#panel-delete-images .panel-footer span").html('<button id="close-selected-images" type="button" class="btn btn-default">Close</button>');
		});
		
		$(document).on("click","#close-selected-images",function(){
			$("#panel-delete-images").hide(800);
			$("#images-for-delete").html("");
			$("#close-selected-images").remove();
		});
	});
</script>
	
	
	
<?php
}else{
?>
<button id="add-more-picture" type="button" class="btn btn-primary">Add gallery</button><br><br>

 <div id="gallery-post-image">

</div>
 
 
<script>
	$(function(){
		$(document).on("click","#add-more-picture",function(){
			$("#gallery-post-image").append('<div id="your-gallery"><div class="panel panel-green"><div class="panel-heading"><h3 class="panel-title">Add gallery</h3>( for multiple upload - hold down key ctrl and select files)</div><div class="panel-body"><div id="input-area-gallery"><input type="file" name="gallery[]" multiple="multiple"></div><div id="img-c-nn"><div id="img-c-n"></div></div></div></div></div>');
			
			$(this).fadeOut(600,function(){
				$(this).remove();
			});
		});
		
		
		
		
	});
</script>

<?php
}
?>

<div class="form-group">
    <label>Content</label>
    <textarea class="form-control textarea-c" rows="20" name="news"><?php echo $post->post_content; ?></textarea>
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
								$current_post_status = Posts::current_post_status($this->id);
								
								
								foreach($post_status as $p_status){
									echo '<div class="radio">';
									echo '<label>';
									if($current_post_status == $p_status){
										echo '<input class="ps_status" type="radio" name="post-status" value="'.$p_status.'" checked>'.ucfirst($p_status) . '<span class="ps_msg"></span>';
									}else{
										echo '<input class="ps_status" type="radio" name="post-status" value="'.$p_status.'">'.ucfirst($p_status) . '<span class="ps_msg"></span>';
									}
									echo '</label>';
									echo '</div>';
								}
								?>
								
							
                                
								<p class="help-block">You can publish your post now or save to draft for later</p>
                            </div>
                            </div>
                        </div>
                        <input type="hidden" id="psstatus" value="<?php echo $post->post_date ?>">


<input id="newDatePublish" type="hidden" name="newDatePublish">
<?php 
if($post->post_status == "draft"){
	?>
<script>           
$(function(){
	function getDate(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();
		var hours = today.getHours();
		var minutes = today.getMinutes();
		var seconds = today.getSeconds();
		
		if(dd<10){
			dd = '0'+dd;
		}
		
		if(mm<10){
			mm = '0'+mm;
		}
		
		if(seconds<10){
			seconds = "0"+seconds;
		}
		if(minutes<10){
			minutes = "0"+minutes;
		}
		if(hours<10){
			hours = "0"+hours;
		}
		
		today = yyyy+'-'+mm+'-'+dd + " " + hours + ":" + minutes + ":" + seconds; 
		return today;
	}


	
 	$(document).on("click",".ps_status",function(){
 		var status = $(this).val();
 		var pdate = $("#psstatus").val();

		if(status == "publish"){
			$(this).siblings(".ps_msg").html(" <input id='post-status2' style='padding:0px 0px 0px 6px' type='text' name='post-status2' value='"+pdate+"'>" + " You can use <button type='button' id='btn-crdate22'>Current date-time</button> or else.");
		}else{
			$(".ps_msg").html("");
		}
 		
 	}); 

 	$(document).on("click","#btn-crdate22",function(){
		var currentdatetime = getDate();
		$("#post-status2").val(currentdatetime);
		$(this).html("Return original date-time");
		$(this).attr("id","btn-orgdatetime");
 	 });

 	$(document).on("click","#btn-orgdatetime",function(){
		var orgdatetime = $("#psstatus").val();
		$("#post-status2").val(orgdatetime);
		$(this).html("Current date-time");
		$(this).attr("id","btn-crdate22");
 	 });  
                 
})
</script>
	<?php 
}else if ($post->post_status == "publish"){
	?>
	<script type="text/javascript">
		var crdateTime = getDate();
		 $("#newDatePublish").val(crdateTime);

	function getDate(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();
		var hours = today.getHours();
		var minutes = today.getMinutes();
		var seconds = today.getSeconds();
		
		if(dd<10){
			dd = '0'+dd;
		}
		
		if(mm<10){
			mm = '0'+mm;
		}
		
		if(seconds<10){
			seconds = "0"+seconds;
		}
		if(minutes<10){
			minutes = "0"+minutes;
		}
		if(hours<10){
			hours = "0"+hours;
		}
		
		today = yyyy+'-'+mm+'-'+dd + " " + hours + ":" + minutes + ":" + seconds; 
		return today;
	}
	
	</script>
	<?php 
}
?>

<button id="btn_submit_update" type="submit" name="btn_submit" class="btn btn-primary">Update</button>
<button type="reset" class="btn btn-default">Reset</button>               
</div>
</form>
</div>
<br><br>   
<input id="ref-post-id" type="hidden" value="<?php echo $this->id; ?>">

<?php
if(isset($_POST['btn_submit'])){
	$author22 = Users::get_by_id(Admin::get_user_id());
	$active_post_image = Posts_image::get_post_image_name($this->id);
	$post_edit = new Posts_edit;
	$post_edit->post_title = strip_tags(trim($_POST['title']));
	
	$nName = strip_tags(trim($_POST['title']));
	$post_edit->post_name = $post_edit->setPostNameEdit($nName);
	
	$post_edit->post_introduction = '';
	$post_edit->post_image = (!empty($_FILES['image']['name'])) ? Posts_image::get_image_new_name($_FILES['image']['name'],$_FILES['image']['type']): Posts_image::get_post_image_name($this->id);
	$post_edit->post_content = htmlentities(trim($_POST['news']));
	$post_edit->post_category = (isset($_POST['category'])) ? strip_tags(trim($_POST['category'])) : "page";
	$post_edit->post_type = "page";
	$post_edit->comment_status = 'closed';
	$post_edit->post_status = strip_tags(trim($_POST['post-status']));
	$post_edit->post_author = Posts::get_post_author($this->id);

	if(Validation::post_validation($post_edit->post_title,$post_edit->post_introduction,$post_edit->post_content,$post_edit->post_category,$post_edit->post_type,$post_edit->comment_status,$post_edit->post_status,$post_edit->post_author)){

		if(isset($_FILES['image']['type'])){
			if(!empty($_FILES['image']['type'])){
				if(Validation::post_image_validation($_FILES['image']['type'],$_FILES['image']['size'])){
					
					if(isset($_FILES['gallery']['name'])){
						$post_gallery = new Posts_gallery;
						$post_gallery->create_post_gallery($this->id);
						Users::setUserActivity($author22->username, "Added a new photos in post",$this->id);
					}
				
					 if($post->post_status == "draft" && $post_edit->post_status == "publish"){
							Posts_insert::change_post_date($this->id,$_POST['post-status2']);
					}else if($post->post_status == "publish" && $post_edit->post_status == "draft"){
						Posts_insert::change_post_date2($this->id,$_POST['newDatePublish']);
					}
					
					$post_edit->update($this->id);
					
					Categories::delete_mulitple_categories($this->id);
					Categories::insert_mulitple_categories($this->id,$_POST['category']);
					
					Users::setUserActivity($author22->username, "Edited a post",$this->id);
				
					$post_image = new Posts_image;
					$post_image->insert_image($_FILES['image']['tmp_name'],$post_edit->post_image);
					Posts_image::delete_previous_image($active_post_image);
					
					?>
						<script>
							$(function(){
								$("#succesfulModal").modal("show");
							});
						</script>
					<?php
				}else{
				?>
					<script>
					$(function(){
						$("#validationError").modal("show");
					});
					</script> 
				<?php
				}
			}else{
				// if isset and if is empty
				
				if(isset($_FILES['gallery']['name'])){
					$post_gallery = new Posts_gallery;
					$post_gallery->create_post_gallery($this->id);
					Users::setUserActivity($author22->username, "Added a new photos in post",$this->id);
				}
				
				if($post->post_status == "draft" && $post_edit->post_status == "publish"){
					Posts_insert::change_post_date($this->id,$_POST['post-status2']);
				}else if($post->post_status == "publish" && $post_edit->post_status == "draft"){
					Posts_insert::change_post_date2($this->id,$_POST['newDatePublish']);
				}
					
				
				
				
				$post_edit->post_image = "none";
				Posts_image::delete_previous_image($active_post_image);
				
				$post_edit->update($this->id);
				
				Categories::delete_mulitple_categories($this->id);
				Categories::insert_mulitple_categories($this->id,$_POST['category']);
				Users::setUserActivity($author22->username, "Edited a post",$this->id);
					?>
					<script>
						$(function(){
							$("#succesfulModal").modal("show")
						});
					</script>
					<?php
			}
		}else{
			if(isset($_FILES['gallery']['name'])){
				$post_gallery = new Posts_gallery;
				$post_gallery->create_post_gallery($this->id);
				Users::setUserActivity($author22->username, "Added a new photos in post",$this->id);
			}
			
			if($post->post_status == "draft" && $post_edit->post_status == "publish"){
				Posts_insert::change_post_date($this->id,$_POST['post-status2']);
			}else if($post->post_status == "publish" && $post_edit->post_status == "draft"){
				Posts_insert::change_post_date2($this->id,$_POST['newDatePublish']);
			}
				

			$post_edit->update($this->id);
			Categories::delete_mulitple_categories($this->id);
			Categories::insert_mulitple_categories($this->id,$_POST['category']);
			Users::setUserActivity($author22->username, "Edited a post",$this->id);
					?>
					<script>
						$(function(){
							$("#succesfulModal").modal("show");
						});
					</script>
					<?php
		}
	}else{
					?>
				<script>
				$(function(){
					$("#validationError").modal("show");
				});
				</script> 
				<?php
	}

	
	
	
	
}




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
						<?php $post_gallery = new Posts_gallery; echo $post_gallery->get_error_gallery(); ?>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- // Modal END -->
			  
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
						<?php $post_gallery->get_information(); ?>
						<?php $post_gallery->get_error_gallery(); ?>
						<span id="<?php echo $this->id; ?>" class="apv-id"></span>
							<script>
								$(function(){
									$(document).on("click","#admin-view",function(){
										var id_el = $(".apv-id").attr("id");
										
										$.ajax({
											url: 'pages/admin_view/',
											type: 'post',
											data: {'id':id_el},
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
			  
<script>
	$(document).on("click","#close-post-success",function(){
			var id = $("#ref-post-id").val();
			window.open('pages/edit/'+id, '_self');
		});


</script>
			  

<?php
SiteFunc::master_footer();

?>