$(function(){

	$("#use2form").on("submit",function(e){
		$("#register-content").html('<div style="margin:5px auto 0 auto;width:25px;"><img src="public/img/loading.gif" width="22">');
		show_register_modal();
		
		var r_fname,r_lname,r_username,r_email,r_password;
		
		r_fname = $("#first-name").val();
		r_lname = $("#last-name").val();
		r_username = $("#username_r").val();
		r_email = $("#email").val();
		r_password = $("#r_password").val();
		
		$.ajax({
			url: path+'user/register_data',
			type: 'post',
			data: {'first_name':r_fname,'last_name':r_lname,'username':r_username,'email':r_email,'password':r_password},
			success: function(msg){
				$("#register-content").html(msg);
				show_register_modal();
			}
		});

		 e.preventDefault();
	});
});
	