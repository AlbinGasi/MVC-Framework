<?php
SiteFunc::master_header("Library","Post gallery","<li><a href='media/'>Media</a></li><li>Posts with gallery</li>");

?>
			  <!-- Modal -->
			  <div class="modal fade" id="post-view" role="dialog">
				<div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
					
					<div class="modal-body" style="padding: 0;">
						<div id="modal-body-post-view">
						
						
						</div>
					</div>
					<div class="modal-footer">
					 <a id="my_ch_edit_gal" href="#" class="btn btn-primary" role="button">Edit gallery</a>
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
			  <!-- // Modal END -->


<div class="col-lg-12">
                        <h2>All posts with gallery</h2>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Date</th>
                                        <th>Edit</th>
                                        <th>View</th>
                           
                                    </tr>
                                </thead>
                                <?php 
									$rows = Media_index::get_gallery_rows_number();
									
									$paginationGallery = Config::get("ADMIN/pagination_gallery_post_limit");
									if(Pagination::get_instance($this->pg,$paginationGallery,$rows)){
									$start = Pagination::$start;
									$limit = Pagination::$limit;														
									$get_user_username = Users::get_by_id(Admin::get_user_id());
									$posts = Media_index::get_posts_with_gallery($start,$limit);
									echo "<tbody>";
									
									if($posts != null){
									foreach($posts as $k => $v){
											echo "<tr>";
											echo "<td>". Posts::if_more_than10($v['post_title'])."</td>";
											echo "<td>".$v['post_author']."</td>";
											echo "<td>".$v['post_date']."</td>";
											
											if(Admin::can_view_2()){
												echo "<td><a href='".Config::get('path')."posts/edit/".$v['post_id']."'><i class='fa fa-fw fa-edit'></i></</a></td>";
											}else if($get_user_username->username == $v['post_author']){
												echo "<td><a href='".Config::get('path')."posts/edit/".$v['post_id']."'><i class='fa fa-fw fa-edit'></i></</a></td>";
											}else{
												echo "<td></td>";
											}
											
											echo "<td><span class='view-post' id='".$v['post_id']."'><i class='fa fa-fw fa-eye'></i></span></td>";
											echo "</tr>";	
									}
									}
									echo "</tbody>";
									}
								?>
                            </table>
									<?php Pagination::show("media/index/"); ?>
							
							
                        </div>
					</div>

<script>

$(function(){
	$(".view-post").click(function(){
			var id_el = $(this).attr("id");
			
			$.ajax({
				url: 'media/admin_view_gallery/',
				type: 'post',
				data: {'id':id_el},
				success: function(feedback_view){
					$("#modal-body-post-view").html(feedback_view);
					edit_link = $("#post_id_val").val();
					$("#my_ch_edit_gal").attr("href","posts/edit/"+edit_link);
					
				$('#post-view').modal('show');
				}
			});
			
		});
});

</script>


 
 <?php
SiteFunc::master_footer();
?>