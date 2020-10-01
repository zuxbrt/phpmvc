<?php

namespace core;

class Request {

    protected $resolver;

    public function __construct() {
        $this->resolver = new Resolver();
    }

    /**
     * Capture request to server and extract parameters.
     */
    public function capture() {

        Auth::check();

        $requested_url = $_SERVER['REQUEST_URI'];
        $request_method = $_SERVER['REQUEST_METHOD'];
        //$request_parameters = $_SERVER['argv'];

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $acceptable_headers = $_SERVER['HTTP_ACCEPT'];
        $accepted_encoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
        $user_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : null;


        return $this->resolver->resolve(
            $requested_url, 
            $request_method
        );
        
        // header("Content-Type: application/json; charset=UTF-8");
        // echo json_encode($_SERVER);
    }
}