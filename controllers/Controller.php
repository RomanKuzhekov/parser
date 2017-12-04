<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 27.11.2017
 * Time: 0:14
 */

namespace controllers;


abstract class Controller
{
    public function getPage(string $url)
    {
        $content = file_get_contents($url);
        $dom = new \DOMDocument();
        @$dom->loadHTML($content);
        return new \DOMXPath($dom);
    }

}