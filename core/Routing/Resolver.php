<?php

namespace Core;

use Core\Error\ErrorResponse;
use ReflectionClass;

class Resolver
{
    public $errorHandler;

    public function __construct()
    {
        $this->errorHandler = new ErrorResponse();
    }

    /**
     * Get requested resource from url.
     */
    public function resolve(string $uri, string $method, $arguments)
    {
        $requested_resource = $this->getResourceFromUri($uri);
        if($requested_resource){
            $controller = $this->findControllerFromResource($requested_resource);
            die($controller);
        }
        return '/';
    }


    /**
     * Get resource from url.
     * @param string $url
     */
    protected function getResourceFromUri(string $uri)
    {
        $url_string_parts = explode('/', $uri);
        foreach($url_string_parts as $string_part){
            if(strlen($string_part) > 3){
                return strtolower($string_part);
            }
        }
    }

    /**
     * Get controller from requested resource.
     * @param string $requested_resource.
     */
    protected function findControllerFromResource(string $requested_resource)
    {
        $controllers = scandir('../src/controllers');

        if(count($controllers) > 0){
            foreach($controllers as $controller){
                if(strlen((string)$controller) < 14){
                    continue;
                }

                $name_and_extension = explode('.', $controller);

                if(count($name_and_extension) > 1){
                    $filename = $name_and_extension[0];
                    $extension = $name_and_extension[1];
                    
                    if($extension === 'php'){
                        $resource_name = strtolower(str_replace('Controller', '', $filename));
                        if($requested_resource === $resource_name){
                            $class_with_path = "src\Controllers\ ${filename}";
                            $class_with_path = str_replace(' ', '', $class_with_path);
                            $class = new ReflectionClass($class_with_path);
                            return $class;
                        }
                    }
                }
            }

            $this->errorHandler->returnMessage('warning', 'Controller for resource "' . $requested_resource .'" not found');
        } else {
            $this->errorHandler->returnMessage('info', 'No controllers found.');
            return null;
        }
    }
}