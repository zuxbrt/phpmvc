<?php

namespace core\Database;

use core\Config;
use core\Interfaces\Database\ConnectionInterface;
use Core\Response;
use Exception;
use PDO;

class MySql implements ConnectionInterface
{
    private static $connectionType;
    private static $host;
    private static $port;
    private static $database;
    private static $username;
    private static $password;
    private static $dsn;
    public $errorHandler;

    public static $_connection;

    /**
     * Connect to database.
     * TODO sqlite (and others)
     */
    public function connect()
    {
        $config = new Config();

        self::$connectionType   = $config->getDBConf('DATABASE_CONNECTION');
        self::$host             = $config->getDBConf('DATABASE_HOST');
        self::$port             = $config->getDBConf('DATABASE_PORT');
        self::$database         = $config->getDBConf('DATABASE_NAME');
        self::$username         = $config->getDBConf('DATABASE_USERNAME');
        self::$password         = $config->getDBConf('DATABASE_PASSWORD');
        self::$dsn              = $config->getDBConf('DATABASE_SOCKET_DSN');
        
        if (!self::$_connection) {
            try {
                //if(self::$dsn !== null){
                    self::$_connection = @new PDO("mysql:unix_socket=".self::$dsn."; mysql:host=".self::$host."; dbname=".self::$database, self::$username, self::$password);
                //} else {
                    //$connect = @new PDO("mysql:host=$this->host; dbname=$this->database", $this->username, $this->password);  
                //}
                self::$_connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            } catch (Exception $e) {
                return Response::send($e->getMessage(), 500);
            }

        }
        return self::$_connection;
    }

    public function query($query)
    {
        
    }
}