<?php

namespace src\Controllers;

use core\Controller;
use core\Response;
use Post;

class PostController extends Controller
{
    protected $response;

    public function __construct()
    {
        $this->response = new Response();
    }
    
    /**
     * Show post.
     */
    public function get($id)
    {
        if($id){
            $post = new Post();
            $data = $post->get($id);
            if(is_array($data)){
                return Response::send($data, 200);
            } else {
                return Response::send(null, 404);
            }
        }
    }

    /**
     * Create new post.
     */
    public function create(array $data)
    {
        $post = new Post();
        $action = $post->create($data);
        if(empty($action)){
            return Response::send('Success', 200);
        } else {
            return Response::send($action, 400);
        }
    }

    /**
     * Update post.
     */
    public function update(array $data)
    {
        $post = new Post();
        $action = $post->update($data);
        if(empty($action)){
            return Response::send('Success', 200);
        } else {
            return Response::send($action, 400);
        }

    }

    /**
     * Delete post.
     */
    public function delete($id)
    {
        $post = new Post();
        $action = $post->delete($id);
        if(empty($action)){
            return Response::send('Success', 200);
        } else {
            return Response::send($action, 400);
        }
    }

    /**
     * Get all posts.
     */
    public function getAll()
    {
        $post = new Post();
        $posts = $post->getAll();
        if(is_array($posts)){
            return Response::send($posts, 200);
        } else {
            return Response::send(null, 404);
        }
    }
}