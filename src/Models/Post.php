<?php

use core\Database\Mapper;

class Post
{
    private $posts_mapper;
    private $post_data;

    public function __construct()
    {
        $this->posts_mapper = new Mapper('posts');
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
     * Update post.
     */
    public function update($post_data)
    {
        return $this->posts_mapper->update($post_data);
    }

    /**
     * Delete post by id.
     */
    public function delete($id)
    {
        return $this->posts_mapper->delete($id);
    }


    /**
     * Get all posts.
     */
    public function getAll()
    {
        return $this->posts_mapper->getAll();
    }

}