<?php

namespace Core\Orm;

Class QueryBuilder {

    private $db;
    private $statement;
    private $attributes;
    private $model;
    private $one = false;

    public function __construct($db) {
        $this->db = $db;
    }

    private function find($table) {
        $this->statement = "SELECT * FROM ".$table;
        $this->model = 'App\\Models\\';
        $this->model .= ucfirst($table);
        return $this;
    }

    public function findOne($table) {
        $this->find($table);
        $this->one = true;
        return $this;
    }
    public function findAll($table) {
        $this->find($table);
        return $this;
    }

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

    public function limit($limit) {
        $this->statement .= " LIMIT ".$limit;
        return $this;
    }

    public function execute(){
        return $this->db->q($this->statement, $this->attributes, $this->model, $this->one);
    }

}
