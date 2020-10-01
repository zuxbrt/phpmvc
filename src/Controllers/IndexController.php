<?php

namespace src\Controllers;

use core\Response;
use core\Template;

class IndexController
{  
    public function index()
    {
        return Template::view('index.html');
        //return Response::send('Hello!', 200);
    }
}