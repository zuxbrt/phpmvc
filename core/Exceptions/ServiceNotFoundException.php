<?php

namespace core\Exceptions;

use core\Interfaces\Exceptions\NotFoundExceptionInterface;

class ServiceNotFoundException extends \Exception implements NotFoundExceptionInterface
{
    
}