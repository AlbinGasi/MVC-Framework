<?php

class Alerts
{
	
	public static function get_alert($type,$strong=null,$txt=null,$print=null){
		if($strong === null){
			$alert = "<div class='alert alert-".$type."'>".$txt."</div>";
		}else if($txt === null){
			$alert = "<div class='alert alert-".$type."'><strong id='msg_val'>".$strong."</strong></div>";
		}else{
			$alert = "<div class='alert alert-".$type."'><strong id='msg_val'>".$strong."</strong> ".$txt."</div>";
		}
		if($print == "return"){
			return $alert;
		}else{
			echo $alert;
		}
	}



}
?>



