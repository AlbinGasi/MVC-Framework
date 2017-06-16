var modal = $("#info");
var close_info = $(".close-reg");

close_info.click(function(){
	modal.css("display","none");
});

function show_modal(){
	modal.fadeIn(250,function(){
		//modal.css({"display":"block"});
	});

}

/* SECOND MODAL */

var modal_reg = $("#register-modal");
var close_reg = $(".close-reg");
var close_reg_act = $(".close-reg");

close_reg.click(function(){
	modal_reg.css("display","none");
});

function show_register_modal(){
	modal_reg.fadeIn(250,function(){
	});

}
/* END */
function show_resend_activation_modal(cus_modal){
	$(cus_modal).fadeIn(250,function(){
	});
}
close_reg_act.click(function(){
	$("#modal-resend").css("display","none");
});

$(function(){

	$("#use1form").on("submit",function(e){
		var username,password,errors;
		username = $("input[name='username_l']").val();
		password = $("input[name='password_l']").val();

		errors = "";
		if(username.trim() == ""){
			errors += "<p>Enter your username</p>";
		}
		if(password.trim() == ""){
			errors += "<p>Enter your password</p>";
		}
		
		if(errors != ""){
			$("#info_msg").html("<div class='alert-danger'>"+errors+"</div>");
			show_modal();
			
		}else{
			$.ajax({
				url: path+'user/login_data',
				type: 'post',
				data: {'username':username,"password":password},
				success: function(msg){
					$("#info_msg").html(msg);
					check_succes = $("#msg_val").html();
					if(check_succes == "Successful"){
						$(".loading-info").html('<img src="public/img/loading.gif" width="40">');
						show_modal();
						setTimeout(function(){
							window.open('index/','_self');
						}, 2000);
					}else if(check_succes == "Activation!"){
						$("#activation_button").html(' <button type="button" id="btn_resend" class="btn btn-primary">Resend activation code</button>');
						show_modal();
					}else{
						show_modal();
					}
					

					
				}
			});
		}

		 e.preventDefault();
		
	})

	/* click on resend activation */
	$(document).on("click","#btn_resend",function(){
				modal.css("display","none");
				$("#resend_email").val("");
				$("#resend_msg").html("");
				show_resend_activation_modal("#modal-resend");
			});
		$(document).on("click","#resend_act_code", function(){
				$("#resend_msg").html('<div style="margin:5px auto 0 auto;width:25px;"><img src="public/img/loading.gif" width="22">');
				var email;
				email = $("#resend_email").val();
				$.ajax({
				url: path+'user/resend_activation',
				type: 'post',
				data: {'email_resend':email},
				success: function(msg){
					$("#resend_msg").html(msg);
					check_succes = $("#msg_val").html();
				}
			});
			});
	
});
		
		