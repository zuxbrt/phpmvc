<?php

namespace core\Database;

use core\Interfaces\Database\InstanceInterface;

class Instance
{
    private static $pdo_instance = null;

    /**
     * TODO - sqlite and other
     */
    public static function getInstance()
    {
        if(self::$pdo_instance == null){
            $connection = new MySql();
            self::$pdo_instance = $connection->connect();
        }
        return self::$pdo_instance;
    }
}