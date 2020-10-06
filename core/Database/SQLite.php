<?php

namespace core\Database;

use core\Config;
use core\Interfaces\Database\ConnectionInterface;
use Core\Response;
use Exception;
use PDO;

class SQLite implements ConnectionInterface
{
    /**
     * PDO instance
     * @var type 
     */
    public static $_connection;

    /**
     * Connect to database.
     * TODO sqlite (and others)
     */
    public function connect()
    {
        if (self::$_connection == null) {
            self::$_connection = new \PDO("sqlite:" . 'sqlite.db');
        }
        return self::$_connection;
    }

    public function query($query)
    {
        
    }
}