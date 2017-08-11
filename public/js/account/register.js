$(function(){

$('.message a').click(function(){
	var title = $('title').first();

	switch(title.html()){
		case 'Login':
			title.html('Register');
		break;
		case 'Register':
			title.html('Login');
		break;
	}
	
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
   $('.alert').html('');
   $("#msgReg").css('display','none');
});

});



function validateEmail(email) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailReg.test(email);
	}
	
	function checkNumeric(n){
		var numeric = /^\d+$/g;
		return numeric.test(n);
	}

	var error = new Object();
	error.username = false;
	error.first_name = false;
	error.last_name = false;
	error.born = false;
	error.email = false;
	error.password = false;
	error.repassword = false;

$("#register").keyup(function(e){

	var username = this.username;
	var first_name = this.first_name;
	var last_name = this.last_name;
	var born = this.born;
	var email = this.email;
	var password = this.password;
	var repassword = this.repassword;


	if(email.value.trim() == ""){
		$("input[name='email']").css('border','1px solid #f20');
		$(".errorMessage.email").css('display','block');
		$(".errorMessage.email").html('Email address can not be empty.');
		error.email = false;
	}else{
		$("input[name='email']").css('border','0');
		em = email.value.trim();
		if(!validateEmail(em)){
			$("input[name='email']").css('border','1px solid #f20');
			$(".errorMessage.email").css('display','block');
			$(".errorMessage.email").html('Use valid email address.');
			error.email = false;
		}else{
			$("input[name='email']").css('border','0');
			$(".errorMessage.email").css('display','none');
			error.email = true;
			$.ajax({
				dataType: 'json',
				type: 'post',
				data: {'email':email.value.trim()},
				url: site_url+'/account/check_data_for_register',
				success: function(response){
				}
			}).done(function(response){
				if(response[0].messageEmail == 'success'){
					$("input[name='email']").css('border','0');
					$(".errorMessage.email").css('display','none');
					error.email = true;
				}else{
					$("input[name='email']").css('border','1px solid #f20');
					$(".errorMessage.email").css('display','block');
					$(".errorMessage.email").html(response[0].messageEmail);
					error.email = false;
					$("#register button").attr('disabled',true);
				}
			});
		}
	}

	if(username.value.trim() == ""){
		$("input[name='username']").css('border','1px solid #f20');
		$(".errorMessage.username").css('display','block');
		$(".errorMessage.username").html('Username can not be empty.');
		error.username = false;
	}else if(username.value.trim().length <= 3){
		$("input[name='username']").css('border','1px solid #f20');
		$(".errorMessage.username").css('display','block');
		$(".errorMessage.username").html('Username must be longer than 3 character.');
		error.username = false;
	}else{
		$("input[name='username']").css('border','0');
		$(".errorMessage.username").css('display','none');
		error.username = true;
		$.ajax({
			dataType: 'json',
			type: 'post',
			data: {'username':username.value.trim()},
			url: site_url+'/account/check_data_for_register',
			success: function(response){
			}
		}).done(function(response){
			if(response[0].messageUsername == 'success'){
				$("input[name='username']").css('border','0');
				$(".errorMessage.username").css('display','none');
				error.username = true;
			}else{
				$("input[name='username']").css('border','1px solid #f20');
				$(".errorMessage.username").css('display','block');
				$(".errorMessage.username").html(response[0].messageUsername);
				error.username = false;
				$("#register button").attr('disabled',true);
			}
		});
	}

	if(first_name.value.trim() == ""){
		$("input[name='first_name']").css('border','1px solid #f20');
		$(".errorMessage.first_name").css('display','block');
		$(".errorMessage.first_name").html('Can not be empty.');
		error.first_name = false;
	}else if(first_name.value.trim().length <= 3){
		$("input[name='first_name']").css('border','1px solid #f20');
		$(".errorMessage.first_name").css('display','block');
		$(".errorMessage.first_name").html('First name must be longer than 3 character');
		error.first_name = false;
	}else{
		$("input[name='first_name']").css('border','0');
		$(".errorMessage.first_name").css('display','none');
		error.first_name = true;
	}

	if(last_name.value.trim() == ""){
		$("input[name='last_name']").css('border','1px solid #f20');
		$(".errorMessage.last_name").css('display','block');
		$(".errorMessage.last_name").html('Can not be empty.');
		error.last_name = false;
	}else if(last_name.value.trim().length <= 3){
		$("input[name='last_name']").css('border','1px solid #f20');
		$(".errorMessage.last_name").css('display','block');
		$(".errorMessage.last_name").html('Last name must be longer than 3 character.');
		error.last_name = false;
	}else{
		$("input[name='last_name']").css('border','0');
		$(".errorMessage.last_name").css('display','none');
		error.last_name = true;
	}

	if(born.value.trim() == ""){
		$("input[name='born']").css('border','1px solid #f20');
		$(".errorMessage.born").css('display','block');
		$(".errorMessage.born").html('Can not be empty.');
		error.born = false;
	}else{
		$("input[name='born']").css('border','0');
		$(".errorMessage.born").css('display','none');
		error.born = true;
	}

	var pass1err = true;
	if(password.value.trim() == ""){
		$("input[name='password']").css('border','1px solid #f20');
		$(".errorMessage.password").css('display','block');
		$(".errorMessage.password").html('Can not be empty');
		error.password = false;
	}else if(password.value.trim().length <= 5){
		$("input[name='password']").css('border','1px solid #f20');
		$(".errorMessage.password").css('display','block');
		$(".errorMessage.password").html('Password must be longer than 5 character.');
		error.password = false;
	}else{
		$("input[name='password']").css('border','0');
		$(".errorMessage.password").css('display','none');
		pass1err = false;
		error.password = true;
	}

	pass2err = true;
	if(repassword.value.trim() == ""){
		$("input[name='repassword']").css('border','1px solid #f20');
		$(".errorMessage.repassword").css('display','block');
		$(".errorMessage.repassword").html('Can not be empty');
		error.repassword = false;
	}else if(repassword.value.trim().length <= 5){
		$("input[name='repassword']").css('border','1px solid #f20');
		$(".errorMessage.repassword").css('display','block');
		$(".errorMessage.repassword").html('Repassword must be longer than 5 character');
		error.repassword = false;
	}else{
		$("input[name='repassword']").css('border','0');
		$(".errorMessage.repassword").css('display','none');
		pass2err = false;
		error.repassword = true;
	}

	if(pass1err == false && pass2err == false){
		if(password.value.trim() != repassword.value.trim()){
			$("input[name='password']").css('border','1px solid #f20');
			$("input[name='repassword']").css('border','1px solid #f20');
			$(".errorMessage.password").css('display','block');
			$(".errorMessage.password").html('Passwords do not match.');
			$(".errorMessage.repassword").css('display','block');
			$(".errorMessage.repassword").html('Passwords do not match.');
			error.password = false;
			error.repassword = false;
		}else{
			$("input[name='password']").css('border','0');
			$("input[name='repassword']").css('border','0');
			$(".errorMessage.password").css('display','none');
			$(".errorMessage.repassword").css('display','none');
			error.password = true;
			error.repassword = true;
		}
	}

	if(error.username == true && error.first_name == true && error.last_name == true && error.born == true && error.email == true && error.password == true && error.repassword == true){
		$("#register button").removeAttr('disabled');
	}else{
		$("#register button").attr('disabled', true);
	}
});

	$('#register').submit(function(e){
			var username = this.username;
			var first_name = this.first_name;
			var last_name = this.last_name;
			var born = this.born;
			var email = this.email;
			var password = this.password;
			var repassword = this.repassword;
			var register_user = true;
		$.ajax({
			beforeSend: function(xhr) {
    			//xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
    			$("#loadingImg").css('display','block');
 			},
			dataType: "json",
			type: 'post',
			data: {'register_user':register_user,'usernameR':username.value.trim(),'first_name':first_name.value.trim(),'last_name':last_name.value.trim(),'born':born.value.trim(),'emailR':email.value.trim(),'password':password.value.trim(),'repassword':repassword.value.trim()},
			url: site_url+'/account/check_data_for_register',
			success: function(response){
				
			},error: function(e){
				console.log(e);
			}
		}).done(function(response){
			if(response[0].messageRegister == 'success'){
				$("#msgReg").css('display','block');
				$("#msgReg").html(response[0].messageRegisterText);
				$("#loadingImg").css('display','none');
				 $("#register").find('input').val(''); 
				 $("#register button").attr('disabled',true);
			}else{
				$("#msgReg").css('display','block');
				$("#msgReg").html(response[0].messageRegisterText);
			}
		});
   		e.preventDefault();
	});