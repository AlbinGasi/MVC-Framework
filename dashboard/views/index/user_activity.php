<?php
SiteFunc::master_header("User activity","All User activity","<li><a href='user_activity'>User activity</a></li>");

if(!Admin::can_view_2()){
	Alerts::get_alert("danger","You can't access to this area.");
	SiteFunc::master_footer();
	return false;
}
$userActivity = $this->index->getUsersActivityNumber();

echo "<input type='hidden' id='valpath' value='".Config::get('full_path')."'>";
?>
<div class="col-md-12">
	<p>Type a number of activity you want to delete, and earlier activity will be deleted.
	</p>
</div>
<div class="col-md-12">
<div class="col-md-3">
<button type="button" class="btn btn-primary">Activities: <span class="badge"><?php echo $userActivity ?></span></button>
</div>
<div class="col-md-2">
	<div class="form-group">
		<input type="text" class="form-control" id="actForDelete">
	</div>
</div>
<div class="col-md-2">
<button type="button" class="btn btn-primary" id="btn-delete">Delete</button>
</div>

</div>
<div class="col-md-12" id="msg"></div>

<script>


$("#btn-delete").on("click",function(){
	stopAllTimeOut();

	function stopAllTimeOut(){
		var id = window.setTimeout(function() {}, 0);
		while (id--) {
		    window.clearTimeout(id); // will do nothing if no timeout with id is present
		}
	}
	var actNumber = $("#actForDelete").val();
	var valpath = $("#valpath").val();

	$.ajax({
		url: valpath+'user_activity_delete',
		type: 'post',
		data: {'actNumber':actNumber},
		beforeSend: function(){
			$("#msg").html("Deleting...");
		},
		success: function(msg){
			$("#msg").html(msg);
		},
		complete: function(tr){
			$("#actForDelete").val("");
			setTimeout(function(){
				$("#msg").html("");
			}, 3300);
		}
		
	})
})
	

</script>


<div class="col-md-12">
<div class="table-responsive">
	<table class="table table-hover table-striped">
      	<tbody id="all_activity">

      	</tbody>

</table>
</div>





<script type="text/javascript">
$(function(){

var track_page = 1;
var loading  = false;

load_contents(track_page);

$(window).scroll(function() { 
	if($(window).scrollTop() + $(window).height() >= $(document).height()) { 
		track_page++; 
		load_contents(track_page);
	}
});




function load_contents(track_page){
    if(loading == false){
        loading = true;
        $('.loading-info').show();
        $.ajax({
				url: 'user_activity_load',
				type: 'post',
				data: {'page':track_page},
				success: function(data){
					loading = false;
					if(data.trim().length == ""){
		                $('.loading-info').css({"width":"100%","text-align":"center"});
		                $('.loading-info').html("<p>No more records!</p>");
						return false;
		            }
		             $('.loading-info').hide();
					 $("#all_activity").append(data);
				}
			})
    }
}
});
</script>

</div>

<?php	
SiteFunc::master_footer();
?>