<?php

class Bootstrap
{
    public function __construct(){
		$CGN = Config::get("ADMIN/controller_get_name"); //Controller GET name
		
        if(!isset($_GET[$CGN])){
            $controller = "IndexController";
            $method = "index";
            $params = null;

            $c = new $controller;
            $c->$method();
            return false;

        }else{
             $url = $_GET[$CGN];
             $url = explode("/",$url);
			 
			 /*$src = strpos($url, "/");

			if($src){
			 $url = explode("/", $url);
			}else{
			  $url = $url . "/";
			  $url = explode("/", $url);
			}*/
			 
			 

             $controller = ucfirst($url[0]) . "Controller";
             $method = (!empty($url[1])) ? lcfirst($url[1]) : "index";
             $params = (isset($url[2])) ? $url[2] : null;
             $params_s = (isset($url[3])) ? $url[3] : null;
			 $params_s = (isset($url[3])) ? $url[3] : null;
			 $params_n = (isset($url[4])) ? $url[4] : null;
			 $params_p = (isset($url[5])) ? $url[5] : null;
			 
			 if(!class_exists($controller)){
				 $controller = "IndexController";
				 $method = $url[0];
				 $c = new $controller;
				 if(method_exists($c,$method)){
						if($params != null && $params_s != null && $params_n != null && $params_p != null){
                            $c->$method($params,$params_s,$params_n,$params_p);
                        }else if($params != null && $params_s != null && $params_n != null){
                            $c->$method($params,$params_s,$params_n,$params_p);
                        }else if($params != null && $params_s != null){
							$c->$method($params,$params_s);
						}else if($params != null){
                            $c->$method($params);
                        }else{
                            $c->$method();
                        }
                   }else{
                       self::error("index");
                   }
			 }
			 
			 

              if(class_exists($controller)){
                      $c = new $controller;
                   if(method_exists($c,$method)){
					   if($params != null && $params_s != null && $params_n != null && $params_p != null){
                            $c->$method($params,$params_s,$params_n,$params_p);
                        }else if($params != null && $params_s != null && $params_n != null){
                            $c->$method($params,$params_s,$params_n,$params_p);
                        }else if($params != null && $params_s != null){
							$c->$method($params,$params_s);
						}else if($params != null){
                            $c->$method($params);
                        }else{
                            $c->$method();
                        }
                   }else{
                       self::error("index");
                   }
              }else{
                 self::error("index");
              }

        }
    }

    /*private*/ static function error($method){
       $controller = "ErrorController";
       $c = new $controller;
       $c->$method();

    }


}









?>