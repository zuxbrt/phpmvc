<?php

namespace src\Controllers;

use core\Response;

class IndexController
{  
    public function index()
    {
        return Response::send('Hello!', 200);
    }
}