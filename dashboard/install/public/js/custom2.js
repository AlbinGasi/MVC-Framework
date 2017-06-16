function createCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}
function eraseCookie(name) {
    createCookie(name,"",-1);
}



$(function(){
	$("#iw-btn-check").click(function(){
		$("#iw-ifsuccess").html("");
		var host = $("#dbhost").val();
		var user = $("#dbuser").val();
		var password = $("#dbpassword").val();
		var dbname = $("#dbname").val();
		
		$.ajax({
			url: 'pages/check_connection.php',
			type: 'post',
			data: {'host':host,'user':user,'password':password,'dbname':dbname},
			beforeSend: function(){
				$("#dbmsg").html('<img src="public/img/loading.gif">');
			},
			success: function(msg){
				$("#dbmsg2").html(msg);
				$("#dbmsg").html("");
			},
			complete: function(tr){
				recmsg = $("#recmsg").html();
				if(recmsg == "Connection is successful."){
					$("#iw-ifsuccess").html('<h3>Now when your connection with database successful you can create table in your database.</h3><table><tr><td>Choos your table prefix: </td><td><input style="width:100px;" type="text" name="tblprefix" id="tblprefix" placeholder="iw_"></td><td></td></tr><tr><td>Table type: </td><td><input style="width:100px;" type="text" name="tbltype" id="tbltype" value="InnoDB"></td><td>Use MyISAM or InnoDB</td></tr><tr><td><button class="iw-btn2" id="iw-btn-add">Create table in database</button></td><td><span class="generalsp" id="curmsg"></span></td><td></td></tr></table>');
				}
			}
		});
	});
	
	$(document).on("click","#iw-btn-add",function(){
		$("#iw-onmstep").html("");
		var host = $("#dbhost").val();
		var user = $("#dbuser").val();
		var password = $("#dbpassword").val();
		var dbname = $("#dbname").val();
		var tblprefix = $("#tblprefix").val();
		var tbltype = $("#tbltype").val();
		
		$.ajax({
			url: 'pages/create_table.php',
			type: 'post',
			data: {'host':host,'user':user,'password':password,'dbname':dbname,'tblprefix':tblprefix,'tbltype':tbltype},
			beforeSend: function(){
				$("#curmsg").html('<img src="public/img/loading.gif">');
			},
			success: function(msg){
				$("#curmsg").html(msg);
			},
			complete: function(ui){
				spfinmsg = $("#spfinmsg").html();
				if(spfinmsg == "It's done, one more step."){
					$("#iw-onmstep").html('<p>This message means that you are on the last step. Now we still need to create the necessary files and you can start use your CMS.</p><button class="iw-btn2" id="iw-btn-createfiles">Create files</button><span style="padding-left:15px;padding-top:10px;" id="tpmsg"></span>');
				}
			}
			
		
		});
		
		
	});
	
	$(document).on("click","#iw-btn-createfiles",function(){
		var host = $("#dbhost").val();
		var user = $("#dbuser").val();
		var password = $("#dbpassword").val();
		var dbname = $("#dbname").val();
		var tblprefix = $("#tblprefix").val();
		
		var weburl = $("#weburl").val();
		var newsurl = $("#newsurl").val();
		var foldername = $("#foldername").val();
		var cmsurl = $("#cmsurl").val();
		var cmspath = $("#cmspath").val();
		
		
		
		var boothu = "Tx7tRj5b0VAG";
		$.ajax({
			url: 'pages/create_files.php',
			type: 'post',
			data: {'boothu':boothu,'host':host,'user':user,'password':password,'dbname':dbname,'tblprefix':tblprefix,'weburl':weburl,'newsurl':newsurl,'foldername':foldername,'cmsurl':cmsurl,'cmspath':cmspath},
			beforeSend: function(){
				$("#tpmsg").html('<img src="public/img/loading.gif">');
			},
			success: function(msg){
				$("#tpmsg").html(msg);
			},
			complete: function(ui){
				finmsg22 = $("#finmsg22").html();
				if(finmsg22 == "All done! You will be redirect now..."){
					createCookie('scrkey','1Gjk6Db59',7);
					setTimeout(function(){
						window.location.replace("install.php?finish");
					}, 3300);
				}
				
			}
			
		
		});
	});
	
})