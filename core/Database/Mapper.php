<?php 

namespace core\Database;

use PDO;
use PDOException;

class Mapper
{
    private $connection;
    private $table;

    public function __construct(string $table)
    {
        $this->connection = Instance::getInstance();
        $this->table = $table;
    }

    /**
     * Retrieve single record from database by id.
     * @param int $id
     * @param string $table
     */
    public function get(int $id)
    {
        $sql = 'SELECT * FROM '.$this->table.' WHERE '.$this->table.'.id = '.$id;
        $item = [];
        $query = $this->connection->query($sql);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // return response
        if(!empty($result)){
            foreach($result as $key => $val){
                $item[$key] = $val;
            }
            return $item;
        } else {
            return null;
        }
    }

    /**
     * Create resource.
     * @param array $data
     */
    public function create(array $data)
    {   
        $columns = [];
        $values = [];
        $params = [];
        $empty_columns = [];

        // form data for query
        foreach($data as $column => $column_value){
            $formatted = preg_replace('/\s+/', '', $column_value);

            if($formatted == ''){
                array_push($empty_columns, $column);
            }

            array_push($columns, $column);
            array_push($params, ':'.$column);
            $values[':'.$column] = $column_value;
        }

        // avoid inserting empty text
        if(count($empty_columns) > 0){
            return 'Empty values for columns: ' . implode(', ', $empty_columns);
        }

        // query
        $sql = 'INSERT INTO '.$this->table.' ('.implode(', ', $columns).')
        VALUES ('.implode(', ', $params).');';

        $statement = $this->connection->prepare($sql);
        foreach($data as $column => $column_value){
            $statement->bindValue(':'.$column, $column_value);
        }
        
        try {
            $statement->execute($values);
        } catch (PDOException $pdoex) {
            return $pdoex->getMessage();
        }
    }

    /**
     * Update record in database by id. // TODO
     */
    public function update(int $id, array $data){}

    /**
     * Delete record from database by id. // TODO
     */
    public function delete(int $id)
    {
        $init_posts_count = $this->getCount();

        // if it decreased by 1, query was successfull
        $sql = 'DELETE FROM '.$this->table.' WHERE id ='.$id;
        $statement = $this->connection->prepare($sql);
        try {
            $statement->execute();

            $current_posts_count = $this->getCount();
            if($current_posts_count < $init_posts_count){
                return null;
            } else {
                return 'Post not deleted';
            }

        } catch (PDOException $pdoex) {
            return $pdoex->getMessage();
        }

    }


    /**
     * Count of total records for table.
     */
    protected function getCount()
    {
        // query
        $count_query_sql = 'SELECT COUNT(*) as total FROM '. $this->table;
        $count_query = $this->connection->query($count_query_sql);
        $count_result = $count_query->fetch(PDO::FETCH_ASSOC);
        
        if(!empty($count_result)){
            return intval($count_result['total']);
        }
        return 0;
    }
}