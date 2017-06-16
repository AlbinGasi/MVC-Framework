<?php
$page_number = (isset($_POST['page'])) ? $_POST['page'] : 1;
$userActivity = $this->index->getUserActivity_load($page_number);

foreach($userActivity as $img => $vt){
	echo "<tr>";
	if($vt['username'] == "administration"){
		echo "<td>".ucfirst($vt['username'])."</td>";
	}else{
		echo "<td><a href='user/profil/".$vt['username']."'>".ucfirst($vt['username'])."</a></td>";
	}
	echo "<td>".$vt['activity']."</td>";
	if($vt['type'] == "profil"){
		echo "<td><a href='user/profil/".$vt['username']."'>View profil</a></td>";
	}else if($vt['type'] == "adminpass"){
		echo "<td><a href='user/profil/".$vt['username2']."'>View profil</a></td>";
	}else if($vt['type'] == "library"){
		echo "<td><a href='media/library/'>View library</a></td>";
	}else if($vt['type'] == "deleted"){
		echo "<td></td>";
	}else{
		echo "<td><a href='posts/post_view/".$vt['post_id']."'>View post</a></td>";
	}
	
	echo "<td>".$vt['date']."</td>";
	
	echo "</tr>";
}
?>