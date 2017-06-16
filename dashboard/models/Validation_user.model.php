<?php

class Validation_user extends Validation
{
	private static $_db;
	
	private static $_errors = array();

	public static function Init(){
		self::$_db = Connection::get_instance();
	}
	
	
	public static function username_exists($username){
		$query = self::$_db->prepare("SELECT user_id FROM ".Config::get('table_prefix')."users WHERE username = :name");
		$query->bindParam(':name', $username);	
		$query->execute();
		if($query->rowCount() > 0 ){
			return true;
		}else{
			return false;
		}
	}
	public static function email_exists($email){
		$query = self::$_db->prepare("SELECT user_id FROM ".Config::get('table_prefix')."users WHERE email = :mail");
		$query->bindParam(':mail', $email);	
		$query->execute();
		if($query->rowCount() > 0 ){
			return true;
		}else{
			return false;
		}
	}
	
	public static function phone_exists($number){
		$query = self::$_db->prepare("SELECT user_id FROM ".Config::get('table_prefix')."users WHERE phone_number = :number");
		$query->bindParam(':number', $number);	
		$query->execute();
		if($query->rowCount() > 0 ){
			return true;
		}else{
			return false;
		}
	}
	
	
	public static function user_register_validion($first_name,$last_name,$username,$email,$password){
		if(empty($first_name)){
				self::$_errors['first_name'] = "Insert First Name.";
			}else if(strlen($first_name)<2){
				self::$_errors['first_name'] = "Last Name must have more than 2 character.";
			}
		if(empty($last_name)){
				self::$_errors['last_name'] = "Insert Last Name.";
			}else if(strlen($last_name)<2){
				self::$_errors['last_name'] = "Last Name must have more than 2 character.";
			}
			
		if(empty($username)){
				self::$_errors['username'] = "Insert Username.";
			}else if(strlen($username)<3){
				self::$_errors['username'] = "Username must have more than 3 character.";
			}else if(self::username_exists($username)){
				self::$_errors['username'] = "Username alredy exists.";
			}
			
			if(empty($email)){
				self::$_errors['email'] = "Insert Email.";
			}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				self::$_errors['email'] = "Insert valid Email address.";
			}else if(self::email_exists($email)){
				self::$_errors['email'] = "Email alredy exists.";
			}
		
		if(empty($password)){
				self::$_errors['password'] = "Insert Password.";
			}else if(strlen($password)<5){
				self::$_errors['password'] = "Password must have more than 5 character.";
			}
		
			if(empty(self::$_errors)){
				return true;
			}else{
				return false;
			}
	}
	
	public static function user_edit($first_name,$last_name,$username,$username2,$email,$email2){
		if(empty($first_name)){
				self::$_errors['first_name'] = "Insert First Name.";
			}else if(strlen($first_name)<2){
				self::$_errors['first_name'] = "Last Name must have more than 2 character.";
			}
		if(empty($last_name)){
				self::$_errors['last_name'] = "Insert Last Name.";
			}else if(strlen($last_name)<2){
				self::$_errors['last_name'] = "Last Name must have more than 2 character.";
			}
			
		if(empty($username)){
				self::$_errors['username'] = "Insert Username.";
			}else if(strlen($username)<3){
				self::$_errors['username'] = "Username must have more than 3 character.";
			}else if($username == $username2){
				
			}else if($username != $username2){
				if(self::username_exists($username)){
					self::$_errors['username'] = "Username alredy exists.";
				}
			}
			
			if(empty($email)){
				self::$_errors['email'] = "Insert Email.";
			}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				self::$_errors['email'] = "Insert valid Email address.";
			}else if($email == $email2){

			}else if($email != $email2){
				if(self::email_exists($email)){
					self::$_errors['email'] = "Email alredy exists.";
				}
			}
		
			if(empty(self::$_errors)){
				return true;
			}else{
				return false;
			}
	}
	
	public static function email_resend_validation($email){
		if(empty($email)){
				self::$_errors['email'] = "Insert Email.";
			}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				self::$_errors['email'] = "Insert valid Email address.";
			}else if(!self::email_exists($email)){
				self::$_errors['email'] = "Email no exist.";
			}
			
		if(empty(self::$_errors)){
				return true;
			}else{
				return false;
			}
	}
	
	public static function forget_password_change($password){
		if(empty($password)){
				self::$_errors['password'] = "Insert Password.";
			}else if(strlen($password)<5){
				self::$_errors['password'] = "Password must have more than 5 character.";
			}
		
			if(empty(self::$_errors)){
				return true;
			}else{
				return false;
			}
	}
	
	public static function validate_birth_date($d,$m,$y){
		$current_year = date("Y");
		
		if(empty($d) && empty($m) && empty($y)){
			
		}else{
			if(is_numeric($d) && is_numeric($m) && is_numeric($y)){
				if(strlen($d)>2){
					self::$_errors['d'] = "Day can't be longer then two character.";
				}else if($d > 31){
					self::$_errors['d'] = "Error birth day.";
				}
				if(strlen($m)>2){
					self::$_errors['m'] = "Month can't be longer then two character.";
				}else if($m > 12){
					self::$_errors['m'] = "Error birth month.";
				}
				if(strlen($y)<4 || strlen($y)>4){
					self::$_errors['y'] = "Year can' be longer or shorter  then four character.";
				}else if($y > $current_year){
					self::$_errors['y'] = "Error birth year.";
				}
			}else{
				self::$_errors['general'] = "Error birth date.";
			}
		}
		
		if(empty(self::$_errors)){
				return true;
			}else{
				return false;
			}
			
	}
	
	public static function phone_number($num,$num2){
		if(!empty($num)){
			if(!is_numeric($num)){
				self::$_errors['num'] = "Phone number must be numeric";
			}else if(strlen($num)<7){
				self::$_errors['num'] = "Phone number can't be shorter than seven character.";
			}else if($num == $num2){
				//self::$_errors['num'] = "Phone number alredy exists.";
			}else if($num != $num2){
				if(self::phone_exists($num)){
					self::$_errors['num'] = "Phone number alredy exists.";
				}
				
			}
		}
		
		if(empty(self::$_errors)){
			return true;
		}else{
			return false;
		}
	}
	
	public static function check_gender($gender){
		$allow = Users_gen::get_gender();
		if(!empty($gender)){
				if(!in_array($gender,$allow)){
					self::$_errors['gendercheck'] = "The value of the gender is not recognized";
			}
		}
		
		if(empty(self::$_errors)){
			return true;
		}else{
			return false;
		}
		
	}
	
	public static function change_psw($password1,$password2){
		if(empty($password1)){
			self::$_errors['changepsw'] = "Password can't be empty.";
		}else if(strlen($password1)<4){
			self::$_errors['changepsw'] = "The password must be longer than 5 character";
		}
		
		if(empty($password2)){
			self::$_errors['changepsw'] = "Password can't be empty.";
		}else if(strlen($password2)<4){
			self::$_errors['changepsw'] = "The password must be longer than 5 character";
		}
		
		if($password1 != $password2){
			self::$_errors['changepsw'] = "Passwords do not match.";
		}
		
		if(empty(self::$_errors)){
			return true;
		}else{
			return false;
		}
		
	}
	
	
	public static function get_error(){
			echo "<div style='margin-bottom:3px' class='alert alert-danger'>";
			foreach(self::$_errors as $error => $val){
				echo "<p>" . $val . "</p>";
			}
			echo "</div>";
	}
	
}

Validation_user::Init();







?>