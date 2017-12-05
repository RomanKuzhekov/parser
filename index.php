<?php
ini_set('error_reporting', E_ALL);
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

//если нет товаров в бд - парсим товары по новой категории и заносим их в $products
if(!$products){
    $message = $parser->parseProducts($category);
    $products = \models\Product::getProductsByCategory($category);
}
?>




<h2>Парсер с сайта: <a href="https://av.ru" target="_blank">av.ru</a></h2>

<h3>Парсим категорию: <a href="<?=$category->url?>" target="_blank"><?=$category->title?></a></h3>
<h4 style="color: red;"><?=$message?></h4>
<?php foreach ($products as $item) { ?>
    <div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">
        <p>Товар: <a href="<?=$item->url?>" target="_blank"><?=$item->title?></a></p>
        <p><img src="<?=$item->img?>" width="200"></p>
        <p>Цена: <?=$item->price?></p>
    </div>
<?php } ?>








