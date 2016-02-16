<?php

namespace Core\Orm;

use \PDO;

/**
 * Class Database
 * @package Core\Orm
 */
Class Database {

    /**
     * @var string
     */
    private $db_name = "bielles";
    /**
     * @var string
     */
    private $db_user = "root";
    /**
     * @var string
     */
    private $db_pass = "";
    /**
     * @var string
     */
    private $db_host = "localhost";
    /**
     * @var
     */
    private $pdo;

    /**
     * @param $db_name
     * @param string $db_user
     * @param string $db_pass
     * @param string $db_host
     */
    public function __construct($db_name, $db_user="root", $db_pass="", $db_host="localhost"){
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
    }

    /**
     * @return PDO
     */
    private function getPDO() {

        if ( $this->pdo === null ) {
            $pdo = new PDO("mysql:host=".$this->db_host.";dbname=".$this->db_name, $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;

    }

    /**
     * @param $statement
     * @param $attributes
     * @param $class_name
     * @param bool|false $first
     * @return array|mixed
     */
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
