<?php

use Core\Database\Mapper;

class Post
{
    private static $posts_mapper;

    public function __construct()
    {
        self::$posts_mapper = new Mapper();
    }

    /**
     * Get post by id.
     * @param string $id
     */
    public function get(string $id)
    {
        return self::$posts_mapper->get($id, 'posts');
    }

}