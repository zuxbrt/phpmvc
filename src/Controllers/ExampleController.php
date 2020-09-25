<?php

namespace src\Controllers;

use Controller;
use Core\Response;

class ExampleController extends Controller
{
    public function show($id)
    {
        if($id){
            return Response::send("Display data for resource by id: ". $id, 200);
        }
    }
}