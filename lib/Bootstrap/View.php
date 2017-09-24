<?php
namespace lib\Bootstrap;
use \lib\models\Config;
class View
{
    public function __construct(){

    }

    public function render($name,$data = null){
        if(file_exists(Config::PUBLIC_HTML . '/views/'.$name.'.php')) {
            require_once Config::PUBLIC_HTML . '/views/'.$name.'.php';
        } else {
            echo 'Error. Please check you controller. <br>File: <i>' . Config::PUBLIC_HTML . '/views/' . $name . '.php</i>' . ' doesn\'t exist';
        }

    }

    public function include_script(){

    }
}


?>