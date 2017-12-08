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
 * Class Category
 * @package models
 * @property int category_id
 * @property string title
 * @property string url
 * @property int flag
 */
final class Category extends Model
{
    protected static $table = 'categories';
    protected static $fields = [
        'category_id',
        'title',
        'url',
        'flag'
    ];
    protected $primaryKey = 'category_id';

    public static function getRandomCategory()
    {
       return Db::getInstance()->db()->query('SELECT * FROM ' . static::$table . ' ORDER BY RAND() LIMIT 1')->fetchObject();
    }

    public static function getAllCategory()
    {
        return Db::getInstance()->db()->query('SELECT * FROM ' . static::$table . ' WHERE flag=1 ORDER BY title ')->fetchAll();
    }

}