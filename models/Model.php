<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 27.11.2017
 * Time: 0:12
 */

namespace models;

use services\Db;

class Model
{
    protected static $table;
    protected static $fields = [];
    protected $primaryKey = 'id';
    protected $attributes = [];
    private $load = false;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        if (empty(static::$table)) {
            throw new \Exception('Не определили таблицу в:' . get_class($this));
        }

        if(empty(static::$fields)) {
            throw new \Exception('Не определили поля таблицы в:' . get_class($this));
        }
    }

    public function prepareAttributes(array $data)
    {
        foreach ($data as $key => $val){
            if(in_array($key, static::$fields)){
                $this->attributes[$key] = $val;
            }
        }
    }

    protected function bindParams(\PDOStatement $query){
        foreach ($this->attributes as $key => $value){
            $query->bindValue(":$key", $value);
        }
        return $query;
    }

    public function save()
    {
        if($this->load){
            $this->update();
        }else{
            $this->insert();
        }
    }

    protected function update($id)
    {
        $updateColumns = [];
        foreach(array_keys($this->attributes) as $column) {
            $updateColumns[] = "$column = :$column";
        }

        $columns = array_keys($this->attributes);

        if(!empty($this->attributes)){
            $query = Db::getInstance()->db()->prepare('Update ' . static::$table . ' SET (:' . implode(', ', $columns).')');
            $query = $this->bindParams($query);
            $query->execute();
        }
    }

    protected function insert()
    {
        $columns = array_keys($this->attributes);

        if(!empty($this->attributes)){
            $query = Db::getInstance()->db()->prepare('INSERT INTO ' . static::$table . '(' . implode(', ', $columns) . ') VALUES (:' . implode(', :', $columns).')');
            $query = $this->bindParams($query);
            $query->execute();
        }

    }



}