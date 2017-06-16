<?php
SiteFunc::master_header("Comments","All coments","<li><a href='comments/'>Comments</a></li><li>All comments</li>");
$redirectURL = $_SERVER['REQUEST_URI'];
echo "<input type='hidden' id='redirecturl' value='".$redirectURL."'>";
?>
    <div class="modal fade" id="edit-comment" role="dialog">
				<div class="modal-dialog" role="document">
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Edit</h4>
					</div>
					<div class="modal-body">
						<div class="modal-body-edit-comment">


						</div>
                               <br>
					<div id="update-message">

					</div>

					</div>
					<div class="modal-footer">
					<button id="save-comment" type="button" class="btn btn-primary">Update</button>
					  <button id="close-comment" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				</div>
			  </div>
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


     <div class="col-lg-12">
                        <h2>Comments</h2>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Comment</th>
                                        <th>Author</th>
                                        <th>Date</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>View</th>
                                    </tr>
                                </thead>

                                        <tbody id="tblNm">
                                <?php

                                	$rows = Comments::get_comments_rows_number();
                                	
                                	if($rows != 0){
									$paginationGallery = Config::get("ADMIN/pagination_comments_limit");

                                    if(Pagination::get_instance($this->pg,$paginationGallery,$rows)){
									$start = Pagination::$start;
									$limit = Pagination::$limit;

                                    $allComments = Comments::get_all(null,"ORDER BY comment_id DESC LIMIT {$start}, {$limit}");
                                    //$allComments = Comments::get_all_comments();
                                    $get_user_username = Users::get_by_id(Admin::get_user_id());

                                    foreach($allComments as $comment){
                                        echo "<tr>";
                                        echo "<td>" . Posts::if_more_than10($comment['comment']) ."</td>";
                                        echo "<td class='cmtAuthor'>" . $comment['comment_author'] ."</td>";
                                        echo "<td>" . Users_gen::convert_date($comment['comment_date']) ."</td>";


                                        if(Admin::can_view_2()){
												echo "<td><span class='edit-post' id='".$comment['comment_id']."'><i class='fa fa-fw fa-edit'></i></</span></td>";
											}else if($get_user_username->username == $comment['comment_author']){
												echo "<td><span class='edit-post' id='".$comment['comment_id']."'><i class='fa fa-fw fa-edit'></i></</span></td>";
											}else{
												echo "<td></td>";
											}


											if(Admin::can_view_2()){
												echo "<td><span class='delete-post' id='".$comment['comment_id']."'><i class='fa fa-fw fa-trash'></i></span></td>";
											}else if($get_user_username->username == $comment['comment_author']){
												echo "<td><span class='delete-post' id='".$comment['comment_id']."'><i class='fa fa-fw fa-trash'></i></span></td>";
											}else{
												echo "<td></td>";
											}

                                            echo "<td><span class='view-comment' id='".$comment['comment_id']."'><i class='fa fa-fw fa-eye'></i></span></td>";


                                        echo "</tr>";
                                    }

                                ?>
							</tbody>
</table>
		
                                        
                                        <?php
                                            }

                                            Pagination::show("comments/index/");
                                	}else{
                                		echo '</tbody></table>';
                                		Alerts::get_alert("info","","There's no comment");
                                		
                                	}
                                         ?>

                                </div>
                                </div>
<script>
$(".delete-post").click(function(){
			var id = $(this).attr("id");
            var commentAuthor =  $(this).parent().siblings(".cmtAuthor").html();

			if(confirm("Delete this comment?")){
			$.ajax({
				url: 'comments/deletecomment',
				type: 'post',
				data: {'commentId':id,'commentAuthor':commentAuthor},
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

       $(document).on("click",".edit-post",function(){
	    var commentID = $(this).attr("id");
        var commentAuthor = $(this).parent().siblings(".cmtAuthor").html();

			$.ajax({
				url: 'comments/editcomment',
				type: 'post',
				data: {'showEditComment':commentID},
				success: function(msg){
					$(".modal-body-edit-comment").html(msg);
					$("#update-message").html("");
					$('#edit-comment').modal('show');
				}
			});

		});

        $(document).on("click","#save-comment",function(){
            var comment_id = $("#cmtID").val();
            var editComment = "true";
            var comment = $("#editComment").val();
            var postid = $("#pstid").val();
            var commentAuthor2 = $("#commentAuthor2").val();

			$.ajax({
				url: 'comments/editcomment',
				type: 'post',
				data: {'editComment':editComment,'cmtID':comment_id,'editComment':comment,'commentAuthor2':commentAuthor2},
				success: function(msg){
					$("#update-message").html(msg);
                }
			});

		});

        $(".view-comment").click(function(){
			var id_el = $(this).attr("id");

			$.ajax({
				url: 'comments/adminview/',
				type: 'post',
				data: {'id':id_el},
				success: function(feedback_view){
					$("#modal-body-post-view").html(feedback_view);
				$('#post-view').modal('show');
				}
			});

		});



         $(document).on("click","#close-comment",function(){
             var url = $("#redirecturl").val();
        			window.open(url, '_self');
        		});


</script>



<?php
SiteFunc::master_footer();
?>