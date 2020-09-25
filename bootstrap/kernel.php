<?php

use Config\Config;
use Core\Request;
use Core\Response;

class Kernel
{
    /**
     * Check if configuration file is there.
     */
    public function __construct()
    {
        $config = new Config();
        $config_file_exists = $config::checkConfig();

        if($config_file_exists){
            if($config->is_in_debug_mode()){
                ini_set('display_errors', 1); 
                ini_set('display_startup_errors', 1); 
                error_reporting(E_ALL);
            }
        }
    }

    /**
     * Capture incoming request and return desired response.
     */
    public function run()
    {
        // while output buffering is active, no output is sent from the script 
        // (other than headers), instead the output is stored in an internal buffer.
        ob_start();

        $request = new Request();
        $response = new Response();


        // This will send the contents of the output buffer (if any). 
        ob_flush();
        return $request->capture();
    }
}

?>