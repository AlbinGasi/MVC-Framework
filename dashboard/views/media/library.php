<?php
SiteFunc::master_header("Library","Library","<li><a href='media/'>Media</a></li><li>Library</li>");
?>

<div id="panel-delete-images" style="display:none" class="panel panel-green">
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
<div class="row">
<div class="col-lg-12">
	<div id='all-library'>


	</div>
	<div class="loading-info"><img src="public/img/loading.gif"></div>
</div>
</div>

<?php
SiteFunc::get_script("public/js/custom/library_load_more.js");

 if(Admin::can_view_2()){
	SiteFunc::get_script("public/js/custom/library_gallery_delete2.js");
 }
?>





 
 <?php
SiteFunc::master_footer();
?>