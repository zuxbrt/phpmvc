<?php
/**
* Simple autoloader, so we don't need Composer just for this.
*/
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function(){
            // include only mandatory classes TODO
            include '../bootstrap/app.php';
            include '../config/Config.php';
            include '../core/Request.php';
            include '../core/Database/Connection.php';
            include '../core/Error/ErrorResponse.php';
        });
    }
}

Autoloader::register();