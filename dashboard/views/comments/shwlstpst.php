<?php
$allComments = Comments::get_all_comments();
$get_user_username = Users::get_by_id(Admin::get_user_id());

                                    foreach($allComments as $comment){
                                        echo "<tr>";
                                        echo "<td>" . $comment['comment'] ."</td>";
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
											}else if($get_user_username->username == $comment['post_author']){
												echo "<td><span class='delete-post' id='".$comment['comment_id']."'><i class='fa fa-fw fa-trash'></i></span></td>";
											}else{
												echo "<td></td>";
											}


                                        echo "</tr>";
                                    }



?>