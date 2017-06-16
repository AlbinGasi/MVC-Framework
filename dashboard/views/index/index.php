<?php
SiteFunc::master_header("Admin panel","Welcome","<li><a href='index/'>Welcome</a></li><li>Home</li>");

if(Admin::can_view()){
$postNumber = Index::get_news_number();
$categoryNumber = Index::get_categories_number();
$postsWithGallery = Index::get_number_of_posts_with_gallery();
$usersNumber = Index::get_users_number();
$commentNumber = Comments::get_comments_rows_number();

$lastRegUsers = $this->index->lastRegUsers();
$postsWithGalleryName = $this->index->get_posts_with_gallery2();
$lastComments = $this->index->getLatestComments();
$userActivity = $this->index->getUserActivity();

?>
<style>

.hei{
	min-height:280px;
}
</style>
 <div class="col-md-4">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $postNumber; ?></div>
                                        <div>Posts in all category</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts/all">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
					
					 <div class="col-md-4">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tags fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $categoryNumber; ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts/categories">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
					
					 <div class="col-md-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-picture-o fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $postsWithGallery; ?></div>
                                        <div>Posts with gallery</div>
                                    </div>
                                </div>
                            </div>
                            <a href="media/index">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
					
					 <div class="col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $usersNumber; ?></div>
                                        <div>Registered users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="user/">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>


                     <div class="col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-4x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $commentNumber; ?></div>
                                        <div>All Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments/index">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>


<div class="col-md-6 hei">
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Last registered users</h3>
  </div>
  <div class="panel-body" style="padding: 0px 0px 0px 0px; margin:0px 0px -17px 0px;">
 
 <div class="table-responsive">
<table class="table table-hover table-striped">
<tbody>
<?php
foreach ($lastRegUsers as $k => $v){
	echo "<tr>";
	echo "<td><a href='user/profil/".$v['username']."'>".ucfirst($v['username'])."</a></td>";
	echo "<td>".$v['email']."</td>";
	echo "<td>".ucfirst($v['first_name'])."</td>";
	echo "<td>".ucfirst($v['last_name'])."</td>";
	echo "</tr>";
}
?>
</tbody>
</table>
</div>
  </div>
</div>
</div>

<div class="col-md-6 hei">
<div class="panel panel-green">
  <div class="panel-heading">
    <h3 class="panel-title">New gallery</h3>
  </div>
  <div class="panel-body" style="padding: 0px 0px 0px 0px; margin:0px 0px -17px 0px;">
   
<div class="list-group">
<?php 
if($postsWithGalleryName != "none"){
	foreach ($postsWithGalleryName as $p){
		echo '<button style="border-radius:0px;" type="button" class="list-group-item"><a href="posts/post_view/'.$p['post_id'].'">'.Posts::if_more_than10(ucfirst($p['post_title']),37).'</a></button>';
	}
}
?>
</div>
  </div>
</div>
</div>



<?php 
if(Admin::can_view_2()){
	?>
	<div class="col-md-6">
<div class="panel panel-red">
  <div class="panel-heading" style="position:relative;">
    <h3 class="panel-title">Last users activity</h3>
    <a  href="user_activity" class="btn btn-default" style="position:absolute; top:3px;right:3px;padding:5px;" role="button">View all</a>
  </div>
  <div class="panel-body" style="padding: 0px 0px 0px 0px; margin:0px 0px -17px 0px;">

<table class="table table-hover table-striped">
<?php
foreach ($userActivity as $kr => $vt){
	echo "<tr>";
	
	if($vt['username'] == "administration"){
		echo "<td>".ucfirst($vt['username'])."</td>";
	}else{
		echo "<td><a href='user/profil/".$vt['username']."'>".ucfirst($vt['username'])."</a></td>";
	}
	echo "<td>".$vt['activity']."</td>";
	if($vt['type'] == "profil"){
		echo "<td><a href='user/profil/".$vt['username']."'>View profil</a></td>";
	}else if($vt['type'] == "adminpass"){
		echo "<td><a href='user/profil/".$vt['username2']."'>View profil</a></td>";
	}else if($vt['type'] == "library"){
		echo "<td><a href='media/library/'>View library</a></td>";
	}else if($vt['type'] == "deleted"){
		echo "<td></td>";
	}else{
		echo "<td><a href='posts/post_view/".$vt['post_id']."'>View post</a></td>";
	}
	
	echo "<td>".$vt['date']."</td>";
	
	echo "</tr>";
}
?>
</table>

  </div>
</div>
</div>
	
	
	<?php
}
?>


<div class="col-md-6">
<div class="panel panel-yellow">
  <div class="panel-heading">
    <h3 class="panel-title">Last comments</h3>
  </div>
  <div class="panel-body" style="padding: 0px 0px 0px 0px; margin:0px 0px -17px 0px;">
   
<table class="table table-hover table-striped">
<?php 

foreach ($lastComments as $comment => $cmValue){
	echo '<tr>';
	echo '<td>'.Posts::if_more_than10( $cmValue['comment'],20).'</td>';
	echo '<td>'.$cmValue['comment_author'].'</td>';
	
	echo "<td><a href='posts/post_view/".$cmValue['post_id']."#cm".$cmValue['comment_id']."'>View</a></td>";
	
	echo '</tr>';
}

?>
</table>
  </div>
</div>
</div>






            
               
   
                    
                    
                    
                    
                    
                    
                    
                    



<?php
}
SiteFunc::master_footer();
?>