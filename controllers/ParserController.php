<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 27.11.2017
 * Time: 0:08
 */

namespace controllers;
use models\Category;
use models\Product;
use services\Db;


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
        parent::__construct();
        $this->url = $this->config['url'];

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
                        'title' => $this->prepareVar($link->textContent),
                        'url' => $this->prepareVar($href),
                        'flag' => 0
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
        $xpath = $this->getPage($categories->url);
        // выбираем блоки с товарами <div class="b-grid__item">...
        $nav = $xpath->query("//div[@class='b-grid__item']");
        //если не находим товары - выбираем заново рандомную категорию и парсим её

        if ($nav->length !== 0){
            /** @var \DOMElement $item */
            foreach ($nav as $item){
                if($this->count < $this->config['countPars']){
                    $link = $xpath->query(".//div/a[@class='b-product__title js-list-prod-open']", $item)->item(0);
                    $price = $xpath->query(".//div[contains(@class, 'b-price')]", $item)->item(0)->getAttribute('content');
                    $img = $xpath->query(".//img[contains(@class, 'b-product__photo')]", $item)->item(0)->getAttribute('src');
                    $data = [
                        'category_id' => $categories->category_id,
                        'title' => $this->prepareVar($link->textContent),
                        'url' => $this->url . $link->getAttribute('href'),
                        'price' => $this->prepareVar($price),
                        'img' => $this->prepareVar($img)
                    ];

                    $product = new Product();
                    $product->prepareAttributes($data);
                    $product->save();
                    Db::getInstance()->db()->query('Update ' . Category::$table . ' SET flag=1 WHERE category_id =' . $categories->category_id)->execute();
//                    $category = new Category();
//                    $category->prepareAttributes($data);
//                    $category->update($categories->category_id);
                    $this->count++;
                }
            }
            $message = 'Количество товаров: ' . $this->count . 'шт.';
        }else{
            $message = 'Нет товаров по данной категории';
        }
        return $message;
    }

}