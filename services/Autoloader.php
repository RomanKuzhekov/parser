<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 26.11.2017
 * Time: 23:00
 */
namespace services;

class Autoloader
{
    function loadClass($classname){
        $classname = str_replace("app\\", $_SERVER['DOCUMENT_ROOT']."/", $classname);
        $classname = str_replace("\\","/",$classname.".php");
        if(file_exists($classname)){
            require $classname;
        }
    }
}
