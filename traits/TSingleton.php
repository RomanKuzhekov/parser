<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 03.12.2017
 * Time: 23:03
 */

namespace traits;


trait TSingleton
{
    private static $instance = null;

    private function __construct(){}
    private function __clone(){}

    /**
     * @return static
     */
    public static function getInstance()
    {
        if(is_null(static::$instance)){
            static::$instance = new static();
        }
        return static::$instance;
    }
}