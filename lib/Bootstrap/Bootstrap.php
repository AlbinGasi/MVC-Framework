<?php
namespace lib\Bootstrap;
use \lib\models\Config;
class Bootstrap
{
  public function __construct(){
    $CGN = \lib\models\Config::CONTROLLERNAME; //Controller GET name

    $path1 = Config::PUBLIC_HTML . '/pages';
    $path2 = Config::PUBLIC_HTML . '/views';
    $folder_path1 = array_diff(scandir($path1), array('.','..','page-from-base.php'));
    $folder_path2 = array_diff(scandir($path1), array('.','..','page-from-base.php'));

    $contrllers_path = 'lib/controllers';
    $controllers_list = array_diff(scandir($contrllers_path), array('.','..'));

    foreach($controllers_list as $controller_name){
      $controller_name = explode('.', $controller_name);
      $controller_new_name[] = strtolower($controller_name[0]);
    }
    foreach($folder_path1 as $folder_name){
      $folder_name = strtolower($folder_name);
      if(!in_array($folder_name, $controller_new_name)){
        if(is_dir(Config::PUBLIC_HTML . '/views/'.$folder_name)){
          $f1 = array_diff(scandir(Config::PUBLIC_HTML . '/views/'.$folder_name), array('.','..'));
          foreach($f1 as $file){
            if(file_exists(Config::PUBLIC_HTML . '/views/'.$folder_name . '/'.$file)){
              unlink(Config::PUBLIC_HTML . '/views/'.$folder_name . '/'.$file);
            }
          }
          rmdir(Config::PUBLIC_HTML . '/views/'.$folder_name);
        }
      }
    }
    foreach($folder_path2 as $folder_name){
      $folder_name = strtolower($folder_name);
      if(!in_array($folder_name, $controller_new_name)){
        if(is_dir(Config::PUBLIC_HTML . '/pages/'.$folder_name)){
          $f2 = array_diff(scandir(Config::PUBLIC_HTML . '/pages/'.$folder_name), array('.','..'));
          foreach($f2 as $file){
            if(file_exists(Config::PUBLIC_HTML . '/pages/'.$folder_name . '/'.$file)){
              unlink(Config::PUBLIC_HTML . '/pages/'.$folder_name . '/'.$file);
            }
          }
          rmdir(Config::PUBLIC_HTML . '/pages/'.$folder_name);
        }
      }
    }

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
        $new_dir = explode('\\', $controller);
        $new_dir = strtolower($new_dir[3]);
        if(!is_dir(Config::PUBLIC_HTML . '/pages/'.$new_dir)){
          mkdir(Config::PUBLIC_HTML . '/pages/'.$new_dir, 0777, true);
          if(!file_exists(Config::PUBLIC_HTML . '/pages/'.$new_dir . '/index.php')){
            fopen(Config::PUBLIC_HTML . '/pages/'.$new_dir . '/index.php', 'w');
          }
        }
        if(!is_dir(Config::PUBLIC_HTML . '/views/'.$new_dir)){
          mkdir(Config::PUBLIC_HTML . '/views/'.$new_dir, 0777, true);
          if(!file_exists(Config::PUBLIC_HTML . '/views/'.$new_dir . '/index.php')){
            fopen(Config::PUBLIC_HTML . '/views/'.$new_dir . '/index.php', 'w');
          }
        }

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