<?php

namespace Core\Configure;

use Core\Orm\Database;
use Core\Orm\QueryBuilder;

Class Config {

    private static $configuration;
    private static $database;
    private static $queryBuilder;


    public static function getConfig() {
        if ( self::$configuration === null ) {
            self::$configuration = json_decode(file_get_contents("../includes/Config/config.json"));
        }
        return self::$configuration;
    }

    private static function getDb(){
        if ( self::$database === null ) {
            $config = self::getConfig();
            self::$database = new Database($config->database->name, $config->database->user, $config->database->pass, $config->database->host);
        }
        return self::$database;
    }

    public static function QueryBuilder() {
        if ( self::$queryBuilder === null ){
            $db = self::getDb();
            self::$queryBuilder = new QueryBuilder($db);
        }
        return self::$queryBuilder;
    }

}
