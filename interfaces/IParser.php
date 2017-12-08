<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 27.11.2017
 * Time: 0:11
 */

namespace interfaces;


interface IParser
{
    public function getPage(string $url);
}