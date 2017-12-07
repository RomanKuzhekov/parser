<?php
//phpinfo();
ini_set('error_reporting', E_ALL);

require "services/Autoloader.php";

$controller = new \controllers\Controller();
//var_dump($controller->actionIndex());
//var_dump($controller->actionProduct());
$controller->run();



?>



<!--<h2>Парсер с сайта: <a href="https://av.ru" target="_blank">av.ru</a></h2>-->
<!--<div style="display: inline-block; width: 250px; margin-right: 50px;">-->
<!--    <button onclick="javascript:window.location.reload()">Обновить страницу</button>-->
<!--   <p>Меню:</p>-->
<!--    <ul>-->
<!--        --><?php //foreach ($categories as $item) { ?>
<!--            <li><a href="product/--><?//=$item['category_id']?><!--">--><?//=$item['title']?><!--</a></li>-->
<!--        --><?// } ?>
<!--    </ul>-->
<!--</div>-->
<!---->
<!---->
<!--<div style="display: inline-block; width: 700px; vertical-align: top;">-->
<!--<h3>Парсим категорию: <a href="--><?//=$category->url?><!--" target="_blank">--><?//=$category->title?><!--</a></h3>-->
<!--<h4 style="color: red;">--><?//=$message?><!--</h4>-->
<?php //foreach ($products as $item) { ?>
<!--    <div style="border: 1px solid #ccc; padding: 5px; margin: 5px; width: 200px; display: inline-block; vertical-align: top;">-->
<!--        <p><a href="--><?//=$item->url?><!--" target="_blank">--><?//=$item->title?><!--</a></p>-->
<!--        <p><img src="--><?//=$item->img?><!--" width="200"></p>-->
<!--        <p>Цена: --><?//=$item->price?><!-- руб.</p>-->
<!--    </div>-->
<?php //} ?>
<!--</div>-->








