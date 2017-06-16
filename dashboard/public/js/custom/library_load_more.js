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
				url: 'media/library_load_more',
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
					 $("#all-library").append(data);
				}
			})
    }
}
});