<?php
namespace lib\Bootstrap;
class Bootstrap
{
    public function __construct(){
		$CGN = \lib\models\Config::CONTROLLERNAME; //Controller GET name
		
    if(!isset($_GET[$CGN])){
        $controller = '\lib\controllers\Index';
        $method = 'index';
        $params = null;

        $c = new $controller;
        $c->$method();
        return false;

    }else{
        $url = $_GET[$CGN];
        $url = explode('/',$url);
			 
        $controller = '\lib\controllers\\'.ucfirst($url[0]);
        $method = (!empty($url[1])) ? lcfirst($url[1]) : "index";
        $params = (isset($url[2])) ? $url[2] : null;

			 
      if(!class_exists($controller)){
				 $controller = '\lib\controllers\Index';
				 $method = $url[0];
         $params = (isset($url[1])) ? $url[1] : null;
				 $c = new $controller;
				 if(method_exists($c,$method)){
						if($params != null){
              $c->$method($params);
            }else{
              $c->$method();
            }
          }else if (!method_exists($c,$method)) {
            $method = 'index';
            $params = (isset($url[0])) ? $url[0] : null;
            
            if(!method_exists($c, $method)){
              self::error('index');
            }else{
              if($params != null){
                $c->$method($params);
              }else{
                $c->$method();
              }
            }
          }
      }else if(class_exists($controller)){
        $c = new $controller;
        if(method_exists($c,$method)){
            if($params != null){
              $c->$method($params);
            }else{
              $c->$method();
            }
        }else if(!method_exists($c,$method)){
            $params = (isset($url[1])) ? $url[1] : null;
            $method = 'index';
            
            if(!method_exists($c,$method)){
              self::error('index');
            }else{
              if($params != null){
                $c->$method($params);
              }else{
                $c->$method();
              }
            }
        }else{
          self::error('index');
        }
      }
    }
  }

    static function error($method){
       $controller = "\lib\controllers\Error";
       $c = new $controller;
       $c->$method();
    }
}
?>