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
}

?>