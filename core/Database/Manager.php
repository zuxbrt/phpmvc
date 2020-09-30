<?php

namespace core\Database;

use core\Config;
use PDO;
use PDOException;

class Manager
{
    protected $connection;
    protected $db_structure;
    protected $query_string;

    /**
     * Construct connection object.
     * // TODO sqlite.
     */
    public function __construct()
    {
        $connection = new MySql();
        $this->connection = $connection->connect();
        if(file_exists('database-config.php')){
            $this->db_structure = include('database-config.php');
        }
    }

    /**
     * Setup database used for project.
     */
    public function setupDatabase()
    {
        foreach($this->db_structure as $key => $value){
            switch ($key) {
                case 'tables':
                    foreach($value as $table_name => $table_fields){

                        // minimum 2 fields in table requirement
                        if(count($table_fields) < 2){
                            return 'Missing table fields for ' . $table_name;
                        }

                        // form query for creating table
                        $this->create_table($table_name);

                        // form query for creating table fields
                        $this->create_table_fields($table_fields);

                        // execute query
                        return $this->run_query();
                    }
                    break;

                default:
                    # code...
                    break;
            }
        }
    }

    /**
     * Drop existing tables from database.
     */
    public function clearDatabase()
    {
        // get tables
        $query = $this->connection->query("SHOW TABLES");
        $result = $query->fetch(PDO::FETCH_ASSOC);

        // return response
        if(!empty($result)){
            foreach($result as $table){
                $this->query_string = "DROP TABLE " . $table;
                $this->run_query();
            }
        } else {
            return 'No tables in database.';
        }

        return "Dropped tables successfully";
    }

    /**
     * Form sql query for creating database table.
     * @param string $table
     */
    protected function create_table(string $table_name)
    {
        $this->query_string = "CREATE TABLE " . $table_name;
    }


    /**
     * Form sql query for creating database table fields.
     * @param array $fields
     */
    protected function create_table_fields(array $table_fields)
    {
        // open brackets for fields
        $this->query_string .= ' ( ';

        // number of fields
        $total_fields = count($table_fields);
        $position = 1;
        $primary_key = null;


        foreach($table_fields as $field){
            if($field['primary_key']){
                $primary_key = $field['name'];
            }

            // define field attributes
            $field_name         = $field['name'];
            $field_type         = $field['type'];
            $field_attributes   = isset($field['attributes']) ? $field['attributes'] : null;
            $is_null            = $field['is_null'];
            $default            = $field['default'];


            // write to string
            $this->query_string.= $field_name . ' ' . $field_type;

            // primary key
            if($field['primary_key']){
                $this->query_string.= ' AUTO_INCREMENT'; 
            }

            // default field value
            if($default == ''){
                $this->query_string.= ' ' . $is_null;
            } else {
                $this->query_string.= ' NOT NULL DEFAULT ' . $default;
            }

            if($position < $total_fields){
                $this->query_string.= ', ';
            }

            $position++;
        }

        // set PK
        $this->query_string .= ', primary key ('.$primary_key.')';

        // close brackets for fields
        $this->query_string .= ' )';
    }

    /**
     * Execute sql query.
     */
    protected function run_query()
    {
        try {
            $this->connection->exec($this->query_string);
            $message = 'Succesfuly executed query: ' . $this->query_string;
            $this->query_string = '';
            return $message;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}