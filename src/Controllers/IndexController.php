<?php

namespace src\Controllers;

use core\Response;
use core\Template;

class IndexController
{  
    public function index()
    {
        // return template for index
        return Template::view('index.html');
        //return Response::send('Hello!', 200);
    }
}