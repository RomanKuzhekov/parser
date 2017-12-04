<?php
require "services/Autoloader.php";
$parser = new \controllers\ParserController();

//выбираем рандомную категорию из БД для парсинга
$category = \Models\Category::getRandomCategory();

//заносим все категории в БД 1 раз
if($category === false){
    $parser->parseCategories();
    header("Location: /index.php");
}

//выбираем все товары по рандомной категории
$products = \models\Product::getProductsByCategory($category);
//var_dump($products);

//если нет товаров в бд - парсим товары по новой категории
if(!$products){
    $parser->parseProducts($category);
    $products = \models\Product::getProductsByCategory($category);
}

?>
