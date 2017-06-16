$(function() {
    var active,part,href;
	active = $("#active").val();
	part = $("#part").val();
	
	$("#"+active).attr("class","collapse in");
	href = active + "/" + part;
	$("#"+part).attr("class","active_plus");

});	