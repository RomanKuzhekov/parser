<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 27.11.2017
 * Time: 0:08
 */

namespace controllers;
use models\Category;


/**
 * Class ParserController
 * @package controllers
 */
final class ParserController extends Controller
{
    private $url;
    public $config;

    /**
     * ParserController constructor.
     */
    public function __construct()
    {
        $this->config = require "config/config.php";
        $this->url = $this->config[url];

        if(empty($this->url)){
            throw new \Exception("Адрес сайта пустой.");
        }
    }


    public function parseCategories()
    {
        $xpath = $this->getPage($this->url);

        // выбираем блоки с категориями <ul class="b-topmenu-popup__block">...</ul>
        $nav = $xpath->query("//ul[contains(@class, 'b-topmenu-popup__block')]");

        /** @var \DOMElement $item */
        //заходим внутрь каждого блока с категориями
        foreach ($nav as $item){

            /** @var \DOMElement $link */
            //формируем ссылку для каждой категории
            foreach ($item->getElementsByTagName('a') as $link){
                $href = $link->getAttribute('href');

                //подчищаем ссылки
                if(strpos($href, '#') !== false || strpos($href, 'search') !== false || strpos($href, $this->url) !== false){
                    continue;
                }
                $href = $this->url . $href;
                if($link->textContent !== ''){
                    $data = [
                        'title' => $link->textContent,
                        'url' => $href,
                        'flag' => 1
                    ];
                }

                $category = new Category();
                $category->prepareAttributes($data);
                $category->save();

            }
        }
    }

    public function parseProducts($categories)
    {

    }

}