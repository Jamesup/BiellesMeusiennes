<?php

namespace Core\Orm;

/**
 * Class QueryBuilder
 * @package Core\Orm
 */
Class QueryBuilder {

    /**
     * @var
     */
    private $db;
    /**
     * @var
     */
    private $statement;
    /**
     * @var
     */
    private $attributes;
    /**
     * @var
     */
    private $model;
    /**
     * @var bool
     */
    private $one = false;

    /**
     * @param $db
     */
    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * @param $table
     * @return $this
     */
    private function find($table) {
        $this->statement = "SELECT * FROM ".$table;
        $this->model = 'App\\Models\\';
        $this->model .= ucfirst($table);
        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function findOne($table) {
        $this->find($table);
        $this->one = true;
        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function findAll($table) {
        $this->find($table);
        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function where($attributes = []) {
        $this->statement .= " WHERE ";
        foreach( $attributes as $k => $v ) {
                $this->statement .= $k." = :".$k." AND ";
        }
        if (substr($this->statement, -4) === "AND ") {
            $this->statement = trim($this->statement, "AND ");
        }
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function limit($limit) {
        $this->statement .= " LIMIT ".$limit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function execute(){
        return $this->db->q($this->statement, $this->attributes, $this->model, $this->one);
    }

}
