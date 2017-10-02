<?php
/*
 - Administrator: 351 (main) or 350
 - Moderator: 250
 - Assistant: 4
 - Advanced User: 3
 - Simple User: 2
 - Need Activation: 1
 - Deactivated: 0
*/
namespace lib\models;
class Users extends Entity
{
  public static $tableName;
  public static $keyColumn = "user_id";
  private static $_db;

  public static function Init(){
    self::$_db = Connection::getInstance();
    self::$tableName = Config::TBL_PREFIX."users";
  }

  /* Auth.. */

  public function activation_code(){
    $last_user_id = mt_rand(99999,999999);
    $txt = array("t34Hcxgst345tzx","astqwe434e3er","fffsada343sdsf","hsadadf3244sgfgh","4sadag34343df","trsdas451dgh43","dfsf7856sdqf3","35dfgddfg56sf","Js45435fgfsdf3","Oisdasd3sadasd434","2wfdasdfsdf3f3D","SS23sgfdasdas3d","sjhxvdsasdhtsa","2yxyf4345x2SSD","gasfsfs45gyxc32","33yxwsdfsdf45yKkds");
    $rand = rand(0,14);
    $num = mt_rand(10000,50000);
    $num2 = mt_rand(700000,1000000);
    $uniqid = uniqid();
    $user_activation = $last_user_id . $txt[$rand] . $num . $num2 . $uniqid;
    return md5($user_activation);
  }

  public function send_activation_code($send_to,$activation_code){
    $full_path = Config::SITE_URL;

    $subject = "Activation code";
    $formcontent = "For complete your registration, you must activate your account. \n For activation visit the link: 
		".$full_path."/account/activation/$activation_code \n";

    $emailheader  = "MIME-Version: 1.0" . "\r\n";
    $emailheader .= "Content-type: text/plain; charset=UTF-8" . "\r\n";
    $emailheader .= "From: no-reply@no-reply.com \r\n";
    $emailheader .= "Reply-To: no-reply@no-reply.com \r\n";
    $emailheader .= "X-Mailer: PHP/" . phpversion();
    $emailheader .= "X-Priority: 1" . "\r\n";

    $mail = mail($send_to, $subject, $formcontent, $emailheader);
  }

  public function check_activation_code($activation){
    $stmt = self::$_db->prepare("SELECT user_id FROM ".Config::TBL_PREFIX."users WHERE user_activation = :activation");
    $stmt->bindParam(":activation",$activation);
    $stmt->execute();
    if($stmt->rowCount() == 1){
      return true;
    }else{
      return false;
    }
  }

  public function send_new_password($send_to,$new_psw){
    $full_path = Config::SITE_URL;

    $subject = "New Password";
    $formcontent = "If you didn't expect this message just ignore. \n If you want to change password, follow the link: 
		" . $full_path . "/account/setnewpassword/$new_psw \n";

    $emailheader  = "MIME-Version: 1.0" . "\r\n";
    $emailheader .= "Content-type: text/plain; charset=UTF-8" . "\r\n";
    $emailheader .= "From: no-reply@no-reply.com \r\n";
    $emailheader .= "Reply-To: no-reply@no-reply.com \r\n";
    $emailheader .= "X-Mailer: PHP/" . phpversion();
    $emailheader .= "X-Priority: 1" . "\r\n";

    $mail = mail($send_to, $subject, $formcontent, $emailheader);
  }

  public function username_exists($username){
    $query = self::$_db->prepare("SELECT user_id FROM ".Config::TBL_PREFIX."users WHERE username = :name");
    $query->bindParam(':name', $username);
    $query->execute();
    if($query->rowCount() > 0 ){
      return true;
    }else{
      return false;
    }
  }
  public function email_exists($email){
    $query = self::$_db->prepare("SELECT user_id FROM ".Config::TBL_PREFIX."users WHERE email = :mail");
    $query->bindParam(':mail', $email);
    $query->execute();
    if($query->rowCount() > 0 ){
      return true;
    }else{
      return false;
    }
  }

  public function register_user($username,$first_name,$last_name,$born,$email,$password,$activation_code){
    $query = self::$_db->prepare("INSERT INTO ".Config::TBL_PREFIX."users (username,first_name,last_name,born,email,password,user_activation) VALUES (?,?,?,?,?,?,?)");
    $query->bindValue(1,$username);
    $query->bindValue(2,$first_name);
    $query->bindValue(3,$last_name);
    $query->bindValue(4,$born);
    $query->bindValue(5,$email);
    $query->bindValue(6,$password);
    $query->bindValue(7,$activation_code);

    if($query->execute()){
      return true;
    }else{
      return false;
    }
  }

  public static function user_login($data){
    $log1 = $data['log1'];

    $email_c = false;
    if(filter_var($log1, FILTER_VALIDATE_EMAIL)){
      $sap = 'email';
      $email_c = true;
    }else{
      $sap = 'username';
    }

    $stmt = self::$_db->prepare("SELECT * FROM ".Config::TBL_PREFIX."users WHERE {$sap} = :sap AND password = :password LIMIT 1");
    $stmt->bindParam(':sap', $data['log1']);
    $stmt->bindParam(':password', $data['password']);
    $stmt->execute();

    $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    if($stmt->rowCount() > 1){
      Alerts::get_alert("danger","Ther's error, contact the administrator to resolve.");
      return false;
    }else if($stmt->rowCount() == 1){
      if($user['user_status'] == 1){
        Alerts::get_alert("danger","Activation!","You must activate your account.");
      }else if($user['user_status'] == 0){
        Alerts::get_alert("danger","Sorry!","Your account is deactivated, contact the site administrator for new activation.");
      }else{
        if($user[$sap] == $log1 && $user['password'] == $data['password']){
          $siteHASH = Config::HASH_KEY;
          $_SESSION[$siteHASH] = array();
          if($user['user_status'] == 351){
            $_SESSION[$siteHASH]['adminuser'] = "admin351";
          }
          $_SESSION[$siteHASH]['user_status'] = $user['user_status'];
          $_SESSION[$siteHASH]['logedin'] = "successUserLogged_871";
          $_SESSION[$siteHASH]['user_id'] = $user['user_id'];
          $_SESSION[$siteHASH]['password'] = $user['password'];
          $_SESSION[$siteHASH]['username'] = $user['username'];
          $_SESSION[$siteHASH]['email'] = $user['email'];
          Alerts::get_alert("info","Successful", "You will be redirect to index page.");
          $url = \lib\models\Config::SITE_URL;
          echo '<input type="hidden" id="path" value="'.$url.'">';
          echo "<script>var url=document.getElementById('path').value;setTimeout(function(){window.location.href=url },1000);</script>";
        }else{
          if($email_c === true){
            Alerts::get_alert("danger","Error!","Check your email or password.");
          }else{
            Alerts::get_alert("danger","Error!","Check your username or password.");
          }
        }
      }
    }else{
      if($email_c === true){
        Alerts::get_alert("danger","Error!","Check your email or password.");
      }else{
        Alerts::get_alert("danger","Error!","Check your username or password.");
      }
    }
  }

  public static function is_admin(){
    $siteHASH = Config::HASH_KEY;
    $user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
    $stmt = self::$_db->prepare("SELECT user_status FROM ".Config::TBL_PREFIX."users WHERE user_id = :id LIMIT 1");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);

    if($res['user_status'] == 351 || $res['user_status'] == 350){
      return true;
    }else{
      return false;
    }
  }

  public static function is_moderator(){
    $siteHASH = Config::HASH_KEY;
    $user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
    $stmt = self::$_db->prepare("SELECT user_status FROM ".Config::TBL_PREFIX."users WHERE user_id = :id LIMIT 1");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    if($res['user_status'] == 250 || $res['user_status'] == 350 || $res['user_status'] == 351){
      return true;
    }else{
      return false;
    }
  }

  public static function is_assistant(){
    $siteHASH = Config::HASH_KEY;
    $user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
    $stmt = self::$_db->prepare("SELECT user_status FROM ".Config::TBL_PREFIX."users WHERE user_id = :id LIMIT 1");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    if($res['user_status'] == 4 || $res['user_status'] == 250 || $res['user_status'] == 350 || $res['user_status'] == 351){
      return true;
    }else{
      return false;
    }
  }

  public static function is_advanced_user(){
    $siteHASH = Config::HASH_KEY;
    $user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
    $stmt = self::$_db->prepare("SELECT user_status FROM ".Config::TBL_PREFIX."users WHERE user_id = :id LIMIT 1");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    if($res['user_status'] == 3 || $res['user_status'] == 4 || $res['user_status'] == 250 || $res['user_status'] == 350 || $res['user_status'] == 351){
      return true;
    }else{
      return false;
    }
  }

  public static function is_simple_user(){
    $siteHASH = Config::HASH_KEY;
    $user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
    $stmt = self::$_db->prepare("SELECT user_status FROM ".Config::TBL_PREFIX."users WHERE user_id = :id LIMIT 1");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    if($res['user_status'] == 2 || $res['user_status'] == 3 || $res['user_status'] == 4 || $res['user_status'] == 250 || $res['user_status'] == 350 || $res['user_status'] == 351){
      return true;
    }else{
      return false;
    }
  }

  public static function get_user_by_id($id,$return){
    $stmt = self::$_db->prepare("SELECT * FROM ".Config::TBL_PREFIX."users WHERE user_id = :id LIMIT 1");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $res[$return];
  }

  public function get_user_id_from_activation($activation){
    $stmt = self::$_db->prepare("SELECT user_id FROM ".Config::TBL_PREFIX."users WHERE user_activation = :activation");
    $stmt->bindParam(":activation",$activation);
    $stmt->execute();
    $id = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $id['user_id'];
  }

  public function get_user_id_from_email($email){
    $stmt = self::$_db->prepare("SELECT user_id FROM ".Config::TBL_PREFIX."users WHERE email = :email");
    $stmt->bindParam(":email",$email);
    $stmt->execute();
    $id = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $id['user_id'];
  }

  public function get_user_data($data){
    $stmt = self::$_db->prepare("SELECT ".$data['select']." FROM ".Config::TBL_PREFIX . "users WHERE ".$data['where']." = ?");
    $stmt->bindValue(1,$data['bind']);
    $stmt->execute();
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $res[$data['select']];
  }

  public function check_new_psw($new_psw){
    $stmt = self::$_db->prepare("SELECT user_id FROM ".Config::TBL_PREFIX."users WHERE new_psw = :new_psw");
    $stmt->bindParam(":new_psw",$new_psw);
    $stmt->execute();
    $res = $stmt->fetch(\PDO::FETCH_ASSOC);

    if($stmt->rowCount()==1){
      return $res['user_id'];
    }else{
      return false;
    }
  }

  public static function is_loggedin(){
    $siteHASH = Config::HASH_KEY;
    $user_id = (isset($_SESSION[$siteHASH]['user_id'])) ? $_SESSION[$siteHASH]['user_id'] : -122;
    $username = self::get_user_by_id($user_id,'username');
    $password = self::get_user_by_id($user_id,'password');
    $email = self::get_user_by_id($user_id,'email');
    if(isset($_SESSION[$siteHASH]['logedin'])){
      if($_SESSION[$siteHASH]['logedin'] == "successUserLogged_871"){
        if(isset($_SESSION[$siteHASH]['user_id']) && isset($_SESSION[$siteHASH]['password']) && isset($_SESSION[$siteHASH]['username'])){
          if(($_SESSION[$siteHASH]['password'] == $password && $_SESSION[$siteHASH]['username'] == $username) || ($_SESSION[$siteHASH]['password'] == $password && $_SESSION[$siteHASH]['email'] == $email)){
            return true;
          }else{
            return false;
          }
        }else{
          return false;
        }
      }else{
        return false;
      }
    }else{
      return false;
    }
  }
}
Users::Init();


?>