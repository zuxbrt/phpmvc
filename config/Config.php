<?php

namespace Config;

use Core\Error\ErrorResponse;

/**
 * This class is used for retrieving parameters used accross
 * the application - example: database connection
 */
class Config
{
    protected $config_array;
    public $errorHelper;

    /**
     * Check if config file is all right.
     */
    public function __construct()
    {
        $this->errorHelper = new ErrorResponse();
        $config_exists = file_exists(__DIR__.'/../.config');

        if(!$config_exists){
            die('Missing .config file in project root.');
        } else {

            $config_file = file_get_contents(__DIR__.'/../.config');
            $config_file_contents = explode("\n", $config_file);

            if(count($config_file_contents) == 1){
                return $this->errorHelper->returnMessage('error', 'Bad/empty config file. Check .config_example located in project root.');
            }

            foreach($config_file_contents as $config_file_row){
                
                $name_val = explode('=', $config_file_row);
                if(count($name_val) < 1){
                    die('Missing .config key value. Check .config_example');
                }

                if(isset($name_val[0]) && isset($name_val[1])){
                    $this->config_array[$name_val[0]] = $name_val[1];
                }
            }
        }
    }



    /**
     * Check if config file exists.
     */
    public static function checkConfig()
    {
        $config_exists = file_exists(__DIR__.'/../.config');
        if(!$config_exists){
            echo 'Missing .config file in project root.';
            return false;
        }
        return;
    }



    /**
     * Check if app is in debug mode.
     * ( will be used for enabling/disabling php error reporting)
     */
    public function is_in_debug_mode()
    {
        // ini_set('display_errors', 1); 
        // ini_set('display_startup_errors', 1); 
        // error_reporting(E_ALL);
        return true;
    }



    /**
     * Get database connection parameters.
     */
    public function getDBConf(string $param)
    {
        if(isset($this->config_array[$param])){
            if($param !== 'DATABASE_SOCKET_DSN'){
                if($this->config_array[$param] == null){
                    $msg = 'Missing ' . $param . ' value in config file.';
                    return $this->errorHelper->returnMessage('error', $msg);
                }
            }
            return $this->config_array[$param];
        }
    }
}