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



?>
