<?php

namespace core;

use Exception;
use JsonException;
use ReflectionClass;
use ReflectionMethod;

class Resolver
{
    public $errorHandler;

    public function __construct()
    {
    }

    /**
     * Get requested resource from url.
     */
    public function resolve(string $uri, string $request_method)
    {
        $requested_resource = $this->getResourceFromUri($uri);
        if($requested_resource){

            $controller = $this->findControllerFromResource($requested_resource);

            if($controller){
                $controller_method     = $this->getControllerMethod($uri, $requested_resource, $request_method);
                if($controller_method){

                    $controller         = $controller->newInstanceWithoutConstructor();
                    $method_exists      = method_exists($controller, $controller_method);

                    if($method_exists){
                        $reflectionMethod   = new ReflectionMethod($controller, $controller_method);
                        $has_parameters     = false;

                        $reflection_method_parameters = $reflectionMethod->getParameters();
                        if(!empty($reflection_method_parameters)){
                            $has_parameters = true;
                        }
                        
                        // extract parameters
                        $method_parameters = $this->getParameters($reflection_method_parameters, $uri, $request_method);

                        if($has_parameters){
                            return $controller->$controller_method($method_parameters);
                        }
                        return $controller->$controller_method();
                    } else {
                        return Response::send('Method ' . $controller_method . '() not found in ' . get_class($controller) , 400);
                        // return $this->errorHandler->returnMessage('error', 'Method *' . $method . '* not found in ' . get_class($controller));
                    }
                }

                return Response::send('Method not provided for resource in url: ' . $uri, 404);
            }

            return Response::send('Controller for requested resource - ' . $requested_resource . ' - not found.', 404);
        }
        return '/';
    }


    /**
     * Get resource from url.
     * @param string $url
     */
    protected function getResourceFromUri(string $uri)
    {
        if($uri == '/'){
            return 'index';
        }

        $url_string_parts = explode('/', $uri);
        $url_parts = [];
        foreach($url_string_parts as $string_part){
            if($string_part !== ''){
                if(strlen($string_part) > 0){
                    array_push($url_parts, $string_part);
                }
            }
        }
        
        if(empty($url_parts)){
            return Response::send('Bad url - ', 400);
            // return $this->errorHandler->returnMessage('error',  $uri);
        }

        return $url_parts[0];
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

            return null;
        } else {
            return Response::send('No controllers found.', 500);
            // return $this->errorHandler->returnMessage('info', 'No controllers found.');
        }
    }


    /**
     * Get controller method from uri string.
     * @param string $uri
     * @param string $requested_resource
     */
    protected function getControllerMethod(string $uri, string $requested_resource)
    {
        if($uri == '/'){
            return 'index';
        }

        $url_string_parts = explode('/', $uri);
        $url_parts = [];
        foreach($url_string_parts as $string_part){
            if($string_part !== ''){
                if(strlen($string_part) > 0){
                    array_push($url_parts, $string_part);
                }
            }
        }

        if(!empty($url_parts)){
            if($url_parts[0] === $requested_resource){
                if(isset($url_parts[1])){
                    $string_after_resource = $url_parts[1];
    
                    // if has id - format like /blog/show?1
                    $has_id_param = strpos($string_after_resource, '?');
                    if($has_id_param){
                        $method_and_id = explode('?', $string_after_resource);
                        return $method_and_id[0];
                    }
                    
                    return $string_after_resource;
                }

                // no method
                return null;
            }
        }
    }

    /**
     * Get parameters for method (if it has any)
     * @param $reflection_method_parameters
     * @param string $uri
     */
    protected function getParameters($reflection_method_parameters, string $uri, string $request_method)
    {
        $param_names = [];
       
        foreach($reflection_method_parameters as $arg){
            array_push($param_names, $arg->name);
        }

        switch ($request_method) {
            case 'POST':
                // decode json
                $data = null;
                $raw_data = file_get_contents('php://input');
                $data = json_decode($raw_data, true);

                // check is valid
                $is_valid_json =  ((is_string($raw_data) && (is_object(json_decode($raw_data)) ||
                    is_array(json_decode($raw_data))))) ? true : false;

                // make sure it's not empty
                if($is_valid_json){
                    if(count($data) < 1){
                        return Response::send('Empty JSON string', 400);
                    }
                }

                // return proper response
                if(!$is_valid_json){
                    return Response::send('Invalid JSON string', 400);
                }
                return $data;

            case 'GET':

                if(!empty($param_names)){
                    $method_param_pos = strpos($uri, '?');
                    $url = substr($uri, $method_param_pos);
                    $separated = explode('?', $url);
        
                    if(!$method_param_pos){
                        return Response::send('Missing ? argument for parameter in url: ' .  $uri, 400);
                        // return $this->errorHandler->returnMessage('error', '' . $uri);
                    }
        
                    $param_val = isset($separated[1]) ? $separated[1] : null;
        
                    if(count($separated) < 2){
                        return Response::send('Missing parameter for url:' .  $uri, 400);
                        //return $this->errorHandler->returnMessage('error', ' ' . $uri);
                    }
                    
                    if(!$param_val){
                        return Response::send('Bad parameter in url: ' .  $uri, 400);
                        // return $this->errorHandler->returnMessage('error', '' . $uri);
                    }
                    if(!is_numeric($param_val)){
                        return Response::send('Non numeric value as parameter: ' . $param_names[0] . ' in url - ' . $uri, 400);
                        // return $this->errorHandler->returnMessage('error');
                    }
                    return $param_val;
                }

                break;

            case 'PUT':
                return Response::send('Under construction.', 504);
                break;

            case 'DELETE':

                if(!empty($param_names)){
                    $method_param_pos = strpos($uri, '?');
                    $url = substr($uri, $method_param_pos);
                    $separated = explode('?', $url);
        
                    if(!$method_param_pos){
                        return Response::send('Missing ? argument for parameter in url: ' .  $uri, 400);
                        // return $this->errorHandler->returnMessage('error', '' . $uri);
                    }
        
                    $param_val = isset($separated[1]) ? $separated[1] : null;
        
                    if(count($separated) < 2){
                        return Response::send('Missing parameter for url:' .  $uri, 400);
                        //return $this->errorHandler->returnMessage('error', ' ' . $uri);
                    }
                    
                    if(!$param_val){
                        return Response::send('Bad parameter in url: ' .  $uri, 400);
                        // return $this->errorHandler->returnMessage('error', '' . $uri);
                    }
                    if(!is_numeric($param_val)){
                        return Response::send('Non numeric value as parameter: ' . $param_names[0] . ' in url - ' . $uri, 400);
                        // return $this->errorHandler->returnMessage('error');
                    }
                    return $param_val;
                }
                break;

            default:
            return Response::send('Method Not Allowed' .  $uri, 405);
                break;
        }
    }

}