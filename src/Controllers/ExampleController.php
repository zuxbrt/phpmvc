<?php

namespace src\Controllers;

use Controller;

class ExampleController extends Controller
{
    public function show($id)
    {
        return 'show: ' . $id;
    }
}