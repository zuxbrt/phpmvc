<?php

namespace Core;

class Request
{
    protected $resolver;

    public function __construct()
    {
        $this->resolver = new Resolver();
    }

    /**
     * Capture request to server and extract parameters.
     */
    public function capture()
    {
        $requested_url = $_SERVER['REQUEST_URI'];
        $request_method = $_SERVER['REQUEST_METHOD'];
        $request_parameters = $_SERVER['argv'];

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $acceptable_headers = $_SERVER['HTTP_ACCEPT'];
        $accepted_encoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
        $accepted_encoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
        $user_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        die($this->resolver->resolve(
            $requested_url, 
            $request_method, 
            $request_parameters
        ));

        // used for api-like response
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($_SERVER);
    }
}