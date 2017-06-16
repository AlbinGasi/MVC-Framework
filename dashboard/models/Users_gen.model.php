<?php 
class Users_gen extends Users
{
	private static $_db;
	
	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	public static function get_fname($id){
		$stmt = self::$_db->prepare("SELECT first_name, last_name FROM ".Config::get('table_prefix')."users WHERE user_id = :id LIMIT 1");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$name = ucfirst($res['first_name']) . " " . ucfirst($res['last_name']);
		return $name;
	}
	
	public static function activation_code(){
		$last_user_id = mt_rand(99999,999999);
		$txt = array("t34Hcxgst345tzx","astqwe434e3er","fffsada343sdsf","hsadadf3244sgfgh","4sadag34343df","trsdas451dgh43","dfsf7856sdqf3","35dfgddfg56sf","Js45435fgfsdf3","Oisdasd3sadasd434","2wfdasdfsdf3f3D","SS23sgfdasdas3d","sjhxvdsasdhtsa","2yxyf4345x2SSD","gasfsfs45gyxc32","33yxwsdfsdf45yKkds");
		$rand = rand(0,14);
		$num = mt_rand(10000,50000);
		$num2 = mt_rand(700000,1000000);
		$uniqid = uniqid();
		$user_activation = $last_user_id . $txt[$rand] . $num . $num2 . $uniqid;
		return $user_activation;
	}
	
	public static function send_activation_code($send_to,$activation_code){	
		$full_path = Config::get("full_path");
		
		$subject = "Activation code";
		$formcontent = "For complete your registration, you must activate your account. \n For activation visit the link: 
		".$full_path."user/activation/$activation_code \n";

		$emailheader  = "MIME-Version: 1.0" . "\r\n";
		$emailheader .= "Content-type: text/plain; charset=UTF-8" . "\r\n";
		$emailheader .= "From: no-reply@no-reply.com \r\n";
		$emailheader .= "Reply-To: no-reply@no-reply.com \r\n";
		$emailheader .= "X-Mailer: PHP/" . phpversion();
		$emailheader .= "X-Priority: 1" . "\r\n"; 
	
		$mail = mail($send_to, $subject, $formcontent, $emailheader);
	}
	
	public static function check_activation_code($activation){
		$stmt = self::$_db->prepare("SELECT user_id FROM ".Config::get('table_prefix')."users WHERE user_activation = :activation");
		$stmt->bindParam(":activation",$activation);
		$stmt->execute();
		if($stmt->rowCount() == 1){
			return true;
		}else{
			return false;
		}
	}
	
	public static function get_user_id_from_activation($activation){
		$stmt = self::$_db->prepare("SELECT user_id FROM ".Config::get('table_prefix')."users WHERE user_activation = :activation");
		$stmt->bindParam(":activation",$activation);
		$stmt->execute();
		$id = $stmt->fetch(PDO::FETCH_ASSOC);
		return $id['user_id'];
	}
	
	public static function get_user_id_from_email($email){
		$stmt = self::$_db->prepare("SELECT user_id FROM ".Config::get('table_prefix')."users WHERE email = :email");
		$stmt->bindParam(":email",$email);
		$stmt->execute();
		$id = $stmt->fetch(PDO::FETCH_ASSOC);
		return $id['user_id'];
	}
	
	public static function get_data_by_email($email){
		$stmt = self::$_db->prepare("SELECT user_activation FROM ".Config::get('table_prefix')."users WHERE email = :email");
		$stmt->bindParam(":email",$email);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['user_activation'];
	}
	
	public static function send_new_password($send_to,$new_psw){
		$full_path = Config::get("full_path");
		
		$subject = "New Password";
		$formcontent = "If you didn't expect this message ignore the. \n If you want to change password, follow the link: 
		" . $full_path . "user/set_new_password/$new_psw \n";

		$emailheader  = "MIME-Version: 1.0" . "\r\n";
		$emailheader .= "Content-type: text/plain; charset=UTF-8" . "\r\n";
		$emailheader .= "From: no-reply@no-reply.com \r\n";
		$emailheader .= "Reply-To: no-reply@no-reply.com \r\n";
		$emailheader .= "X-Mailer: PHP/" . phpversion();
		$emailheader .= "X-Priority: 1" . "\r\n"; 
	
		$mail = mail($send_to, $subject, $formcontent, $emailheader);
	}
	
	public static function check_new_psw($new_psw){
		$stmt = self::$_db->prepare("SELECT user_id FROM ".Config::get('table_prefix')."users WHERE new_psw = :new_psw");
		$stmt->bindParam(":new_psw",$new_psw);
		$stmt->execute();
		
		if($stmt->rowCount()==1){
			return true;
		}else{
			return false;
		}
	}
	
	public static function get_id_by_new_psw($new_psw){
		$stmt = self::$_db->prepare("SELECT user_id FROM ".Config::get('table_prefix')."users WHERE new_psw = :new_psw");
		$stmt->bindParam(":new_psw",$new_psw);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['user_id'];
	}
	
	public static function get_psw_by_id($id){
		$stmt = self::$_db->prepare("SELECT new_psw FROM ".Config::get('table_prefix')."users WHERE user_id = :id");
		$stmt->bindParam(":id",$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['new_psw'];
	}
	
	public static function convert_date($g_date){
		$_date = $g_date;
		$_date = explode(" ",$_date);
		$date = $_date[0];
		$date = explode("-",$date);
		$d = $date[2];
		$m = $date[1];
		$y = $date[0];
		
		$complete_date = $d . "." . $m . "." . $y;
		
		return $complete_date;
	}
	
	public static function delete_user($user_id){
		$stmt_ = self::$_db->prepare("SELECT user_id FROM ".Config::get('table_prefix')."users WHERE user_id=:id");
		$stmt_->bindParam(":id",$user_id);
		$stmt_->execute();
		if($stmt_->rowCount() == 1){
			$stmt = self::$_db->prepare("UPDATE ".Config::get('table_prefix')."users SET user_status = 0 WHERE user_id=:id");
			$stmt->bindParam(":id",$user_id);
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public static function check_user_by_username($username){
		$stmt = self::$_db->prepare("SELECT * FROM ".Config::get('table_prefix')."users WHERE username=:username");
		$stmt->bindParam(":username",$username);
		$stmt->execute();
		if($stmt->rowCount()==1){
			return true;
		}else{
			return false;
		}
	}
	
	public static function get_user_by_username($username){
		$stmt = self::$_db->prepare("SELECT * FROM ".Config::get('table_prefix')."users WHERE username=:username");
		$stmt->bindParam(":username",$username);
		$stmt->execute();
		$obj = $stmt->fetchObject(__class__);
		return $obj;
	}
	
	public static function check_user_by_id($user_id){
		$stmt = self::$_db->prepare("SELECT user_id FROM ".Config::get('table_prefix')."users WHERE user_id=:id");
		$stmt->bindParam(":id",$user_id);
		$stmt->execute();
		if($stmt->rowCount()==1){
			return true;
		}else{
			return false;
		}
	}
	
	public static function get_user_age_for_editing($age,$w){
		
		if(empty($age)){
			return false;
		}
		$date = $age;
		$date = explode(".",$date);
		$d = $date[0];
		$m = $date[1];
		$y = $date[2];
		
		switch($w){
			case "d":
			return $d;
			break;
			case "m":
			return $m;
			break;
			case "y":
			return $y;
			break;
		}
		
	}
	
	public static function get_gender(){
		$gender = array("male","female");
		return $gender;
	}
	
	public static function all_users(){
		$stmt = self::$_db->prepare("SELECT * FROM ".Config::get('table_prefix')."users");
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public static function get_not_valdiate_user(){
		$stmt = self::$_db->query("SELECT count(user_id) FROM ".Config::get('table_prefix')."users WHERE user_status=1");
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['count(user_id)'];
	}
	
	public static function get_deleted_user(){
		$stmt = self::$_db->query("SELECT count(user_id) FROM ".Config::get('table_prefix')."users WHERE user_status=0");
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['count(user_id)'];
	}
	
	

}
Users_gen::Init();





?>