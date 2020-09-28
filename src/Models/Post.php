<?php

use Core\Database\Connection;
use Core\Response;

class Post extends Model
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::connect();
    }

    /**
     * Get post by id.
     * @param string $id
     */
    public function get(string $id)
    {
        // query
        $sql = 'SELECT * FROM posts WHERE posts.id = '.$id;
        $post = [];
        $query = $this->connection->query($sql);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // return response
        if(!empty($result)){
            foreach($result as $key => $val){
                $post[$key] = $val;
            }
            return Response::send([$post], 200);
        } else {
            return Response::send(null, 404);

        }
    }

}