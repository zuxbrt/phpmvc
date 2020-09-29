<?php

namespace src\Controllers;

use Controller;
use core\Response;
use Post;

class PostController extends Controller
{
    /**
     * Show post.
     */
    public function show($id)
    {
        if($id){
            $post = new Post();
            return $post->get($id);
        }
    }

    /**
     * Update post.
     */
    public function update($id)
    {
        return Response::send('todo', 501);
    }

    /**
     * Delete post.
     */
    public function delete($id)
    {
        return Response::send('todo', 501);
    }
}