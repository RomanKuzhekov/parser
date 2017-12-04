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
    private $count = 0;

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
       // $categories->url = 'https://av.ru//g/00004330';
        var_dump($categories);
        $xpath = $this->getPage($categories->url);

        // выбираем блоки с товарами <div class="b-grid__item">...
        $nav = $xpath->query("//div[@class='b-grid__item']");

        //если не находит товары - выбираем заново рандомную категорию и парсим её
        if ($nav->length == 0){
            $category = \Models\Category::getRandomCategory();
            self::parseProducts($category);
            exit();
        }

        /** @var \DOMElement $item */
        foreach ($nav as $item){
            if($this->count < $this->config['countPars']){
                $link = $xpath->query(".//div/a[@class='b-product__title js-list-prod-open']", $item)->item(0);

                $this->count++;
                var_dump($link);
            }

        }

      //  var_dump($nav);
    }


}