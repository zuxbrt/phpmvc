<?php
/**
* Simple autoloader, so we don't need Composer just for this.
*/
class Autoloader
{
    public static function register()
    {   
        spl_autoload_register(function(){

            // get current working directory
            $public_path = true;
            $path = getcwd();
            $path_dirs = explode('/', $path);
            $total = count($path_dirs);
            $working_dir = $path_dirs[$total-1];
            if($working_dir !== 'public'){
                $public_path = false;
            }

            if(!$public_path){
                // change working directory to core
                chdir('./core');

                // core items for migrations
                include_once __DIR__.'/Database/Connection.php';
                include_once __DIR__.'/Database/Mapper.php';
                include_once __DIR__.'/Database/Manager.php';
                include_once __DIR__.'/Config.php';
                
                // back to root directory
                chdir('..');
            } else {

                // core items 
                include_once __DIR__.'/Request.php';
                include_once __DIR__.'/Response.php';
                include_once __DIR__.'/Controller.php';
                include_once __DIR__.'/Model.php';
                
                // database
                include_once __DIR__.'/Database/Connection.php';
                include_once __DIR__.'/Database/Mapper.php';
                include_once __DIR__.'/Database/Manager.php';

                include_once __DIR__.'/Helpers/Status.php';
                include_once __DIR__.'/Routing/Resolver.php';

                include_once '../bootstrap/kernel.php';
                include_once '../core/Config.php';
                include_once '../core/Console/Commands.php';
                

                $paths = ['../src/Controllers', '../src/Models', '../src/Views'];

                foreach($paths as $path){
                    $classes = scandir($path);
                    foreach($classes as $class){
                        if($class !== '.' && $class !== '..'){
                            include $path . '/' . $class;
                        }
                    }
                }
            }

        });
    }

}

Autoloader::register();