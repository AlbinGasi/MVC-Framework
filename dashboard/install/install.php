<!DOCTYPE html>
<html>
<head>
<title>IW-CMS PRO Installation</title>
<link rel="stylesheet" href="public/css/layout.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700,700i" rel="stylesheet"> 
<script src="public/js/jquery.js"></script>


</head>
<body>

<div id="iw-main">
<div id="iw-steps">


<div class="iw-step <?php if(!isset($_GET['finish'])) echo "iw-active";?>">
<span class="first-row">settings</span>
<span class="second-row">Configurate your future IW-CMS</span>
</div>

<div class="iw-step <?php if(isset($_GET['finish'])) echo "iw-active";?>">
<span class="first-row">finish</span>
<span class="second-row">Complete installation</span>
</div>

</div>
<div class="dashed"></div>


<?php
if(!isset($_GET['finish'])){
?>
<div class="iw-install">
<h2>Settings</h2>
<table>
<tr>
	<td>Your website URL: </td>
	<td><input style="width:270px;" type="text" name="weburl" id="weburl" placeholder="http://www.yoursite.com/"></td>
	<td>Must be ended with slash "/".</td>
</tr>
<tr>
	<td>News URL: </td>
	<td><input style="width:270px;" type="text" name="newsurl" id="newsurl" placeholder="http://www.yoursite.com/index.php"></td>
	<td>Type url where show your news.</td>
</tr>
<tr>
	<td>Folder name: </td>
	<td><input style="width:270px;" type="text" name="foldername" id="foldername" placeholder="iw-admin"></td>
	<td>Just type your folder name, without slashes.</td>
</tr>

<tr>
	<td>URL from CMS: </td>
	<td><input style="width:270px;" type="text" name="cmsurl" id="cmsurl" placeholder="http://www.yoursite.com/iw-admin/"></td>
	<td>Full URL from CMS. Must be ended with slash "/".</td>
</tr>

<tr>
	<td>PATH from CMS: </td>
	<td><input style="width:270px;" type="text" name="cmspath" id="cmspath" placeholder="/iw-admin/"></td>
	<td>Enter your path from your root folder with slashes at the beginning and at the end.</td>
</tr>
</table>


<h2>Set your database</h2>
<table>
<tr>
	<td>Host name: </td>
	<td><input style="width:270px;" type="text" name="dbhost" id="dbhost"></td>
</tr>
<tr>
	<td>User: </td>
	<td><input style="width:270px;" type="text" name="dbuser" id="dbuser"></td>
</tr>
<tr>
	<td>Password: </td>
	<td><input style="width:270px;" type="text" name="dbpassword" id="dbpassword"></td>
</tr>
<tr>
	<td>Database name: </td>
	<td><input style="width:270px;" type="text" name="dbname" id="dbname"></td>
</tr>
<tr>
	<td></td>
	<td><button class="iw-btn" id="iw-btn-check">Check Database</button> 
	
	<span id="dbmsg"></span>
	
	</td>
</tr>
</table>
<div id="dbmsg2"></div>

<div id="iw-ifsuccess"></div>

<div style="margin-top:20px;" id="iw-onmstep"></div>

<div id="finalMSG"></div>

</div>
<script src="public/js/custom2.js"></script>

<?php
}else if(isset($_GET['finish'])){
	 if(isset($_COOKIE['scrkey'])){
		 if($_COOKIE['scrkey'] == "1Gjk6Db59"){
?>
<div id="iw-finfinish">
<h2 class="text-center">Congratulations!</h2>
<p>Now you can use your CMS. For security reason it would be best to <b>delete the installation folder.</b></p>
<p>Also if you want you can change your configurate file in this location: core/config.php. </p>
<div style="margin-top:20px;"></div>
<p><b>Numbers of display news is defined also in config file in this line:</b></p>
<p class="important-fc">paginator_all_posts, <br>paginator_all_posts_category, <br>paginator_all_posts_of_categories.</p>

<p><b>Your data for loggin:</b> </p>
<p class="important-fc">Username: admin <br> Password: admin</p>
<div style="margin-top:30px;"></div>


<p>You can change your profile details in profile editing page.</p>

<p>Read documentation for security and easy use CMS.</p>
<p><b>How you can add news on your site read in the documentation which you can find in documentation folder.</b></p>

<div style="margin-top:30px;"></div>
<p>I'm Albin Gaši and I'm Web developer specialized in the backend programming. More about me you can find in <a target="_blank" href="http://www.albingasi.com">Albin Gasi</a>.<br> 

</p>
<p>For any question please send me email: albin.g@live.com or add me on skype: albin.gasi</p>
<p>Thank you for using my CMS. I will be glad if I can help anything about CMS and his implements on your site.</p>

<div style="margin-top:20px;"></div>
<p style="color:#777;"><em>When you refresh this page this message will disappear. But everything about this CMS you can find in documentation folder.</em></p>
</div>





<script src="public/js/custom3.js"></script>
<?php
		 }else{
		 echo "<h3>Wrong request. Read documentation for help.</h3><p>Documentation can find in documentation folder.</p>";
	 }
	 }
}



?>




</div>


</body>
</html>