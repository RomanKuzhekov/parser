<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 26.11.2017
 * Time: 22:59
 */

return [
    'url' => 'https://av.ru/',
    'db' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'parser',
        'charset' => 'UTF8'
    ],
    'countPars' => 100,
    'root_dir' => $_SERVER['DOCUMENT_ROOT'] . "/"
];




