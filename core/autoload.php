<?php
/**
* Simple autoloader, so we don't need Composer just for this.
*/
class Autoloader
{
    public static function register()
    {   
        spl_autoload_register(function(){

            include '../bootstrap/kernel.php';

            include '../config/Config.php';
            
            include '../core/Request.php';
            include '../core/Response.php';
            include '../core/Controller.php';
            
            include '../core/Database/Connection.php';
            include '../core/Helpers/Status.php';
            include '../core/Error/ErrorResponse.php';
            include '../core/Routing/Resolver.php';

            $paths = ['../src/Controllers', '../src/Models', '../src/Views'];

            foreach($paths as $path){
                $classes = scandir($path);
                foreach($classes as $class){
                    if($class !== '.' && $class !== '..'){
                        include $path . '/' . $class;
                    }
                }
            }

        });
    }
}

Autoloader::register();