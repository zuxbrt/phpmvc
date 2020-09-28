<?php 

namespace Core\Database;

use Core\Response;
use PDO;

class Mapper
{
    private static $connection;

    public function __construct()
    {
        self::$connection = Connection::connect();
    }

    /**
     * Retrieve single record from database by id.
     * @param int $id
     * @param string $table
     */
    public function get(int $id, string $table)
    {
        $sql = 'SELECT * FROM '.$table.' WHERE '.$table.'.id = '.$id;
        $item = [];
        $query = self::$connection->query($sql);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // return response
        if(!empty($result)){
            foreach($result as $key => $val){
                $item[$key] = $val;
            }
            return Response::send($item, 200);
        } else {
            return Response::send('Not found', 404);
        }
    }

    /**
     * Update record in database by id. // TODO
     */
    public function update(int $id, string $table, array $data){}

    /**
     * Delete record from database by id. // TODO
     */
    public function delete(int $id){}
}