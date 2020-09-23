<?php

use Core\Database\Connection;
use Core\Error\ErrorResponse;

abstract class Controller
{
    public $errorHandler;

    public function __construct()
    {
        $this->errorHandler = new ErrorResponse();
    }
    // public function connect()
    // {
    //     $dbconnect  = new Connection();
    //     $connection = $dbconnect->connect();
    // }
}

?>