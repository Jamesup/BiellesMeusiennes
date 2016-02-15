<?php

namespace Core\Orm;

use \PDO;

Class Database {

    private $db_name = "bielles";
    private $db_user = "root";
    private $db_pass = "";
    private $db_host = "localhost";
    private $pdo;

    public function __construct($db_name, $db_user="root", $db_pass="", $db_host="localhost"){
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    private function getPDO() {

        if ( $this->pdo === null ) {
            $pdo = new PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name, $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;

    }

    public function q($statement, $attributes, $class_name, $first = false) {
        $req = $this->getPDO()->prepare($statement);
        $req->execute($attributes);
        $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        if ( $first ) {
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }
        return $datas;
    }




}
