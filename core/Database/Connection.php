<?php

namespace Core\Database;

use Config\Config;
use Core\Error\ErrorResponse;
use Exception;
use PDO;

class Connection
{
    protected $connectionType;
    protected $host;
    protected $port;
    protected $database;
    protected $username;
    protected $password;
    protected $dsn;
    public $errorHandler;

    /**
     * Set database connection variables from config.
     */
    public function __construct()
    {
        $this->errorHandler = new ErrorResponse();

        $config = new Config();

        $this->connectionType   = $config->getDBConf('DATABASE_CONNECTION');
        $this->host             = $config->getDBConf('DATABASE_HOST');
        $this->port             = $config->getDBConf('DATABASE_PORT');
        $this->database         = $config->getDBConf('DATABASE_NAME');
        $this->username         = $config->getDBConf('DATABASE_USERNAME');
        $this->password         = $config->getDBConf('DATABASE_PASSWORD');
        $this->dsn              = $config->getDBConf('DATABASE_SOCKET_DSN');
    }

    /**
     * Connect to database.
     * Get database connection parameters from configuration file.
     * Defined connection type for mysql for now.
     * TODO sqlite (and others)
     */
    public function connect()
    {
        switch ($this->connectionType) {
            case 'mysql':
                try {
                    if($this->dsn !== null){
                        $connect = new PDO("mysql:unix_socket=$this->dsn; mysql:host=$this->host; dbname=$this->database", $this->username, $this->password);
                    } else {
                        $connect = new PDO("mysql:host=$this->host; dbname=$this->database", $this->username, $this->password);  
                    }
                    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                    return $connect;
                } catch (Exception $e) {
                    return $this->errorHandler->returnMessage('error', $e->getMessage());
                }
            break;
            
            default:
                return $this->errorHandler->returnMessage('info', 'Work in progress for ' . $this->connectionType . ' database type.');
                break;
        }
    }
}