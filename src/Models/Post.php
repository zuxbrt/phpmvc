<?php

use core\Database\Mapper;

class Post
{
    private $posts_mapper;
    private $post_data;

    public function __construct(array $post_data = null)
    {
        $this->posts_mapper = new Mapper('posts');
        if($post_data){
            $this->post_data = $post_data;
        }
    }

    /**
     * Get post by id.
     * @param string $id
     */
    public function get(string $id)
    {
        return $this->posts_mapper->get($id);
    }

    /**
     * Create new post.
     */
    public function create($post_data)
    {
        return $this->posts_mapper->create($post_data);
    }

    /**
     * Delete post by id.
     */
    public function delete($id)
    {
        return $this->posts_mapper->delete($id);
    }

}