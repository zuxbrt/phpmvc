<?php

// hardcoded for now
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

require __DIR__.'../../autoload.php';
$app = new App();
$app->run();

?>