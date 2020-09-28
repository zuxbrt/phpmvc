<?php

namespace src\Controllers;

use Controller;
use Core\Response;
use Post;

class PostController extends Controller
{
    public function show($id)
    {
        if($id){
            $post = new Post();
            return $post->get($id);
        }
    }
}