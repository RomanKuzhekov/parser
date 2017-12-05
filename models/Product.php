<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 27.11.2017
 * Time: 0:12
 */

namespace models;

use services\Db;


/**
 * Class Product
 * @package models
 * @property int id
 * @property int category_id
 * @property string title
 * @property string url
 * @property int price
 * @property string img
 */
final class Product extends Model
{
    protected static $table = 'products';
    protected static $fields = [
        'id',
        'category_id',
        'title',
        'url',
        'price',
        'img'
    ];


    public static function getProductsByCategory($category){
//         $category->category_id = 360;
        $query = Db::getInstance()->db()->prepare('SELECT * FROM ' . static::$table . ' WHERE category_id = :category_id');
        $query->bindValue(":category_id", $category->category_id);
        $query->execute();
        return $query->fetchAll(Db::FETCH_CLASS, self::class);
    }

}