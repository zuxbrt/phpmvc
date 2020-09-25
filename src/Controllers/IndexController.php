<?php

namespace src\Controllers;

use Controller;
use Core\Response;

class IndexController extends Controller
{
    public function index()
    {
        return Response::send('Hello!', 200);
    }
}