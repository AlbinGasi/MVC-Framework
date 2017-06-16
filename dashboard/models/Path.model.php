<?php

class Path
{
    public static function getPath(){
        $path = Config::get("path");
        $link = "<base href='".$path."'>";
        return $link;
    }
}


?>