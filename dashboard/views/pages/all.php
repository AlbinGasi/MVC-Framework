<?php
SiteFunc::master_header("All Pages -> Pages","All Pages","<li><a href='pages/'>Pages</a></li><li>All pages</li>");

if(!Admin::can_view()){
	Alerts::get_alert("danger","You can't access to this area.");
	return false;
}

if(Validation::params3_($this->params3)){
	return false;
}


$draftPost = $this->posts_model->get_postStatus2('page');
?>
			  <!-- Modal -->
			  <div class="modal fade" id="myModal" role="dialog">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Information</h4>
					</div>
					<div class="modal-body">
						<div class="modal-body-delete">
						
						</div>
					</div>
					<div class="modal-footer">
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
						<div id="modal-body-post-view">
						
						
						</div>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- // Modal END -->


<div class="col-lg-12">

<?php 
	if($draftPost != ""){
		?>
		<h3>You have unplublished posts</h3>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Date</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>View</th>

                                    </tr>
                                </thead>
		<?php 
		
		echo "<tbody>";
		foreach($draftPost as $k2 => $v2){
			echo "<tr>";
			echo "<td>". Posts::if_more_than10($v2['post_title'])."</td>";
			echo "<td>".$v2['post_author']."</td>";
			echo "<td>". Users_gen::convert_date($v2['post_date'])."</td>";
		
			if(Admin::can_view_2()){
				echo "<td><a href='".Config::get('path')."pages/edit/".$v2['post_id']."'><i class='fa fa-fw fa-edit'></i></</a></td>";
			}else if($get_user_username->username == $v2['post_author']){
				echo "<td><a href='".Config::get('path')."pages/edit/".$v2['post_id']."'><i class='fa fa-fw fa-edit'></i></</a></td>";
			}else{
				echo "<td></td>";
			}
		
		
			if(Admin::can_view_2()){
				echo "<td><span class='delete-post' id='".$v2['post_id']."'><i class='fa fa-fw fa-trash'></i></span></td>";
			}else if($get_user_username->username == $v2['post_author']){
				echo "<td><span class='delete-post' id='".$v2['post_id']."'><i class='fa fa-fw fa-trash'></i></span></td>";
			}else{
				echo "<td></td>";
			}
				
			echo "<td><span class='view-post' id='".$v2['post_id']."'><i class='fa fa-fw fa-eye'></i></span></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		
		
		?>
		</table>
		
		
		
		<div style="height:10px;background: #DDD;margin-bottom:40px;margin-top:10px;"></div>
		<?php
		
	}

?>





                        <h2>Posts</h2>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Date</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>View</th>

                                    </tr>
                                </thead>
                                <?php
									if(Pagination::get_instance($this->pg)){
									$start = Pagination::$start;
									$limit = Pagination::$limit;
									
									$all_posts = Posts_all::get_all(null," WHERE post_status='publish' and post_type='page' ORDER BY post_date DESC LIMIT {$start}, {$limit}");

									$get_user_username = Users::get_by_id(Admin::get_user_id());
									
									echo "<tbody>";
									foreach($all_posts as $k => $v){
											echo "<tr>";
											echo "<td>". Posts::if_more_than10($v['post_title'])."</td>";
											echo "<td>".$v['post_author']."</td>";
											echo "<td>". Users_gen::convert_date($v['post_date'])."</td>";

											if(Admin::can_view_2()){
												echo "<td><a href='".Config::get('path')."pages/edit/".$v['post_id']."'><i class='fa fa-fw fa-edit'></i></</a></td>";
											}else if($get_user_username->username == $v['post_author']){
												echo "<td><a href='".Config::get('path')."pages/edit/".$v['post_id']."'><i class='fa fa-fw fa-edit'></i></</a></td>";
											}else{
												echo "<td></td>";
											}


											if(Admin::can_view_2()){
												echo "<td><span class='delete-post' id='".$v['post_id']."'><i class='fa fa-fw fa-trash'></i></span></td>";
											}else if($get_user_username->username == $v['post_author']){
												echo "<td><span class='delete-post' id='".$v['post_id']."'><i class='fa fa-fw fa-trash'></i></span></td>";
											}else{
												echo "<td></td>";
											}
											
											echo "<td><span class='view-post' id='".$v['post_id']."'><i class='fa fa-fw fa-eye'></i></span></td>";
											echo "</tr>";		
									}
									echo "</tbody>";
									}
								?>
                            </table>
									<?php Pagination::show(); ?>
							
							
                        </div>
					</div>
</div>


<script>



	$(function(){
		$(".delete-post").click(function(){
			var id = $(this).attr("id");

			if(confirm("Are you sure you want to delete this post?")){
			$.ajax({
				url: 'pages/delete/',
				type: 'post',
				data: {'id':id},
				success: function(feedback){
					$(".modal-body-delete").html(feedback);
					$('#myModal').modal('show');
				}
			});

				$(this).parent().parent().fadeOut(300,function(){
					$(this).remove();
				});

			}
			return false;

		});
		
		$(".view-post").click(function(){
			var id_el = $(this).attr("id");
			
			$.ajax({
				url: 'pages/admin_view/',
				type: 'post',
				data: {'id':id_el},
				success: function(feedback_view){
					$("#modal-body-post-view").html(feedback_view);
				$('#post-view').modal('show');
				}
			});
			
		});

	});
	
	
</script>


<?php
SiteFunc::master_footer();
?>