<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 27.11.2017
 * Time: 0:14
 */

namespace controllers;


use models\Category;
use models\Product;

class Controller
{
    public $config;
    private $action;
    private $defaultAction = "Index";
    private $layout = "main";

    public function __construct()
    {
        $this->config = require "config/config.php";
    }

    public function run($action = null)
    {
        $this->action = $action ?: $this->defaultAction;
        $action = "action".$this->action;
        return $this->$action();
    }

    public function actionIndex()
    {
        //выбираем рандомную категорию из БД для парсинга
        $category = Category::getRandomCategory();

        //заносим все категории в БД 1 раз
        if($category === false){
            (new ParserController())->parseCategories();
            $this->redirect('index.php');
        }

        //выбираем все категории из БД для меню
        $categories = Category::getAllCategory();

        //выбираем все товары по рандомной категории
        $products = Product::getProductsByCategory($category);

        //если нет товаров в бд - парсим товары по новой категории и заносим их в $products
        if(!$products){
            $message = (new ParserController())->parseProducts($category);
            $products = Product::getProductsByCategory($category);
        }

        echo $this->render("parser/index",
            [
                'products' => $products
            ]
        );
    }

    public function actionProduct()
    {
        echo "Product";
    }

    public function render($template, $params)
    {
        return $this->renderTemplate("layouts/main",
            ['content' => $this->renderTemplate($template, $params)]
        );
//        return $this->renderTemplate($template, $params);

    }

    public function renderTemplate($template, $params)
    {
        extract($params);
        ob_start();
        $templatePath = $this->config['root_dir'] . "views/{$template}.php";
        include $templatePath;
        return ob_get_clean();
    }

    private function prepareCategory(){

    }

    private function prepareProduct(){

    }


    public function redirect($url)
    {
        header("Location: /$url");
    }
    
    public function getPage(string $url)
    {
        $content = file_get_contents($url);
        $dom = new \DOMDocument();
        @$dom->loadHTML($content);
        return new \DOMXPath($dom);
    }

    public function prepareVar($var){
        if($var == false || $var == '' || $var == ' '){
            $var = 'Нет значения';
        }
        return trim(strip_tags($var));
    }
}