$(function(){
	$("#btn_sub_comment").click(function(){
		var path = $("#pth_inscmt").val();
		var username = $("#comment_uname").val();
		var comment = $("#comment_txttxt").val();
		var postid = $("#pstid").val();

		$.ajax({
			url: path+"comments/addcomment",
			type: 'post',
			data: {'username':username,'comment':comment,'postid':postid},
			success: function(msg){
				$("#show_msg").html(msg);
				cck_msg = $("#msg_val").html();
				if(cck_msg == "Success"){
					$("#comment_txttxt").val("");

					$.post(path+"comments/lastcomment/"+postid, function(data){
					  $("#wrapper_comment").html(data);
					});


				}
			}
		});
	});

	$(document).on("click",".deleting",function(){
	    var path = $("#pth_inscmt").val();
		var commentID = $(this).attr("id");
        var commentAuthor = $(this).siblings(".comment_author").html();

        if(confirm("Delete this comment?")){
            $.ajax({
                url: path+'comments/deletecomment',
                type: 'post',
                data: {'commentId':commentID,'commentAuthor':commentAuthor},
                success: function(msg){
                }
            });
            $(this).parent().fadeOut(300,function(){
              $(this).remove();
            });
        }
	});

    $(document).on("click",".editing",function(){
    	var path = $("#pth_inscmt").val();
	    var commentID = $(this).attr("id");
        var commentAuthor = $(this).siblings(".comment_author").html();
			$.ajax({
				url: path+'comments/editcomment',
				type: 'post',
				data: {'showEditComment':commentID},
				success: function(msg){
					$(".modal-body-edit-comment").html(msg);
					$("#update-message").html("");
					$('#edit-comment').modal('show');
				}
			});

		});

		$(document).on("click","#save-comment",function(){
		    var path = $("#pth_inscmt").val();
            var comment_id = $("#cmtID").val();
            var editComment = "true";
            var comment = $("#editComment").val();
            var postid = $("#pstid").val();
            var commentAuthor2 = $("#commentAuthor2").val();

			$.ajax({
				url: path+'comments/editcomment',
				type: 'post',
				data: {'editComment':editComment,'cmtID':comment_id,'editComment':comment,'commentAuthor2':commentAuthor2},
				success: function(msg){
					$("#update-message").html(msg);
                    $.post(path+"comments/lastcomment/"+postid, function(data){
					  $("#wrapper_comment").html(data);
					});
				}
			});

		});


});