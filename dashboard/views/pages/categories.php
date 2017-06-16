<?php
SiteFunc::master_header("Categories -> Posts","Categories","<li><a href='posts/'>Posts</a></li><li>Categories</li>");

if(!Admin::can_view_2()){
	Alerts::get_alert("danger","You can't access to this area.");
	SiteFunc::master_footer();
	return false;
}

?>
 <!-- Succes add category MODAL -->
			  <div class="modal fade" id="succesful-modal" role="dialog">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Successful</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-success">
							<strong>Successful</strong> You added a new category.
						</div>
					
					
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
 <!-- END Modal -->	

 <!-- Delete category MODAL -->
			  <div class="modal fade" id="delete-category" role="dialog">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Information</h4>
					</div>
					<div class="modal-body">
						<div class="modal-body-delete-category">
						</div>
					
					
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
 <!-- END Modal -->	 

<div class="row">
<form role="form" action="" method="POST">
<div class="col-lg-4">
<h3>Add new category</h3>
<div class="form-group">
<label>Category name</label>
<input class="form-control" name="category_name">
<p class="help-block">Enter name for your category.</p>
</div>
<button type="submit" name="btn_submit" class="btn btn-primary">Add</button>
<button type="reset" class="btn btn-default">Reset</button>  

</div>
</form>
<?php

if(isset($_POST['btn_submit'])){
	$category = trim(strip_tags($_POST['category_name']));
	
	if(Validation::category_validate($category)){
		$category_f = Posts::set_categoryName($category);
		$cat = new Categories;
		$cat->category_name = $category_f;
		$cat->category_name2 = $category;
		
		$cat->insert();
		
		?>
		<script>
			$(function(){
				$("#succesful-modal").modal("show")
			});
		</script> 
		<?php
	}else{
		?>
		<script>
			$(function(){
				$("#error-category").modal("show")
			});
		</script> 
		<?php
	}
	
}

?>
 <!-- Error MODAL -->
			  <div class="modal fade" id="error-category" role="dialog">
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
 <!-- END Modal -->	






<div class="col-lg-8">
<h3>Categories</h3>
<div class="table-responsive">
<table class="table table-hover table-striped">
<thead>
	<tr>
		<th>ID</th>
		<th>Category name</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
</thead>
<tbody>

	<?php 
		$categories = Categories::get_all();
		foreach($categories as $k => $v){
			echo "<tr>";
			echo "<td style='width:10px;'>".$v['category_id']."</td>";
			echo "<td>".ucfirst($v['category_name2'])."</td>";
			echo "<td><span class='edit-category' id='".$v['category_id']."'><i class='fa fa-fw fa-edit'></i></td>";
			echo "<td><span class='delete-category' id='".$v['category_id']."'><i class='fa fa-fw fa-trash'></i></span></td>";
			echo "</tr>";
		}
	?>
</tbody>
</table>

<!-- Edit category MODAL -->
			  <div class="modal fade" id="edit-category" role="dialog">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Edit</h4>
					</div>
					<div class="modal-body">
						<div class="modal-body-edit-category">


						</div>

					<div id="update-message">

					</div>

					</div>
					<div class="modal-footer">
					<button id="save-category" type="button" class="btn btn-primary">Update</button>
					  <button id="close-category" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
 <!-- END EDIT Modal -->


<script>
	$(function(){
		$(".delete-category").click(function(){
			var id = $(this).attr("id");
			
			if(confirm("Are you sure you want to delete this category?")){
			$.ajax({
				url: 'posts/delete_category/',
				type: 'post',
				data: {'id':id},
				success: function(feedback){
					$(".modal-body-delete-category").html(feedback);
				$('#delete-category').modal('show');
				}
			});
			
			$(this).parent().parent().fadeOut(300,function(){
				$(this).remove();
			});
			
			}
			return false;
			
		});
		
		$(document).on("click",".edit-category",function(){
			var id = $(this).attr("id");
			$.ajax({
				url: 'posts/edit_category/',
				type: 'post',
				data: {'id':id},
				success: function(feedback){
					$(".modal-body-edit-category").html(feedback);
					$("#update-message").html("");
					$('#edit-category').modal('show');
				}
			});
			

			
			
		});

		$(document).on("click","#save-category",function(){
			var id = $("#input-edit-category-id").val();
			var name = $("#input-edit-category").val();
			$.ajax({
				url: 'posts/edit_category/',
				type: 'post',
				data: {'name':name,'catid':id},
				success: function(feedback){
					$("#update-message").html(feedback);
				}
			});

		});

		$(document).on("click","#close-category",function(){
			window.open('posts/categories', '_self');
		});

	});


</script>

</div>
</div>
</div>




















<?php	
SiteFunc::master_footer();
?>



































