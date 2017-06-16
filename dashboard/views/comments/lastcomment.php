<?php
if($this->post_id != null){
	echo Comments::show_last_comment($this->post_id);
}else{
	Alerts::get_alert("danger","Error","Refresh your page.");
}


?>