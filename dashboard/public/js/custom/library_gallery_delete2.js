$(function(){
	
	$(document).on("mouseenter",".img-gallery",function(){
		var btn = '<div id="btn-delete" style="display:inline;position:absolute;right:0px;top:-70px"><button style="width:20px;height:20px;padding:0px;" type="button" class="btn btn-primary"><i class="fa fa-fw fa-trash-o"></i></button></div>';
		$(this).append(btn);
	});
	
	$(document).on("mouseleave",".img-gallery",function(){
		$("#btn-delete").remove();
	});
	
	
	$(document).on("mouseenter",".img-gallery2",function(){
		var btn = '<div id="btn-delete2" style="display:inline;position:absolute;right:0px;top:-10px"><button style="width:20px;height:20px;padding:0px;" type="button" class="btn btn-primary"><i class="fa fa-fw fa-trash-o"></i></button></div>';
		$(this).append(btn);
	});
	
	$(document).on("mouseleave",".img-gallery2",function(){
		$("#btn-delete2").remove();
	});
	
		
	$(document).on("click","#btn-delete",function(){
		var photo_name = $(this).parent().attr("id");
		var alt_name = $(this).parent().attr("data-model");
		var gallery_path = $("input[name='gallery-path']").val();
		
		$("#panel-delete-images").show(800);
		$("#images-for-delete").append('<div id="'+photo_name+'" class="img-gallery2" style="display:inline;position:relative;"><img style="border:1px solid #DDD;border-radius:4px; margin-right:4px;margin-top:8px;padding:4px" class="post-gallery-image" src="'+gallery_path+photo_name+'" width="50" height="50" alt="'+alt_name+'" title="'+alt_name+'"></div>');
		

		$(this).parent().fadeOut(200,function(){
			$(this).remove();
		});
	});
	
	$(document).on("click","#btn-delete2",function(){
			var img_name = $(this).parent(".img-gallery2").attr("id");
			var gallery_dir = $("input[name='gallery-path']").val();
			var r_alt = img_name.split("_");
			alt = r_alt[0];
			
			$("#all-library").prepend('<div id="'+img_name+'" class="img-gallery" style="display:inline;position:relative;"><img style="border:1px solid #DDD;border-radius:4px; margin-right:4px;margin-top:8px;padding:4px" class="post-gallery-image" src="'+gallery_dir+img_name+'" width="165" height="165" title="'+alt+'" alt="'+alt+'"></div>');
		
		
		$(this).parent().fadeOut(100,function(){
			$(this).remove();
		});
		var num = $("#images-for-delete .img-gallery2").length;
		if(num==1){
			$("#images-for-delete").html("");
			$("#panel-delete-images").hide(800);
		}
	});
	
	$(document).on("click","#delete-selected-images",function(){
			var num = $("#images-for-delete .img-gallery2").length;
			var ttt = "duk";
			if(num==0){
				photo_for_delete = "none";
			}else{
				var img_name = $(".img-gallery2").map(function(){
					return $(this).attr("id");
				}).get();
				
				photo_for_delete = img_name.join().replace(/,/g, '|');
			}
			
			$.ajax({
				url: 'media/delete',
				type: 'post',
				data: {'duk':ttt,'names':photo_for_delete},
				success: function(msg){
					$("#images-for-delete").html(msg);
				}
			});
			
			$("#panel-delete-images .panel-footer span").html('<button id="close-selected-images" type="button" class="btn btn-default">Close</button>');
		});
		
		$(document).on("click","#close-selected-images",function(){
			$("#panel-delete-images").hide(800);
			$("#images-for-delete").html("");
			$("#close-selected-images").remove();
		});
	
	
	
});