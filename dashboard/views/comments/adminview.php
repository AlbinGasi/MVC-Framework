<style>
.admin-view-post{
	margin: 0 auto;
	width: 100%;
	word-wrap: break-word;
}

.post-title{
	color: #333;
	font-size: 18px;
	font-weight: bold;
	font-family: Tahoma;
	background: #DDD;
	padding: 5px;
	border-radius: 3px;
	margin-bottom: 4px;
}
.post-introduction{
	font-size:18px;
	font-family: Vedrana;
	letter-spacing: 0.6px;
	margin-bottom: 5px;
}
.post-image{
	margin-bottom:5px;
}

.post-image img{
	border:2px solid #DDD;
	border-radius: 5px;
}
.post-image img:hover{
	opacity: 0.7;
}

.post-content{
	font-family: Arial;
	font-size: 15px;
	letter-spacing: 0.8px;
}

.post-about{
	clear: both;
	margin-bottom: 20px;
	border-bottom: 2px solid #EEE;
	position: relative;
	#background: #EEE;
	height: 27px;
	padding: 5px;
}

.post-about .author{
	position: absolute;
	left: 4px;
}
.post-about .date{
	position: absolute;
	right:4px;
}

</style>

<?php
if(isset($_POST['id'])){
	$id = trim(strip_tags($_POST['id']));
	$post_view = Comments::get_by_id($id);

	?>

<div class="admin-view-post">

<div class="panel panel-default" style="border:0px solid #fff;margin:0px;">
<div class="panel-heading"><h3></h3></div>

 <div class="panel-body">




<div class="post-about">
<div class="author"><strong>By: </strong><span><?php echo ucfirst($post_view->comment_author); ?></span></div>
<div class="date"><strong>Date: </strong><span><?php echo Users_gen::convert_date($post_view->comment_date); ?></span></div>
</div>
<div class="post-introduction">
<?php echo html_entity_decode($post_view->comment); ?>
</div>
</div>
</div>
</div>
<?php
}
?>