<?php

namespace Core;

use Core\Database\Connection;

class Request
{
    public function __construct()
    {
        $dbconnect = new Connection();
        $dbconnect->connect();
    }

    /**
     * Capture request to server and extract parameters.
     */
    public function capture()
    {
        $requested_url = $_SERVER['REQUEST_URI'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $acceptable_headers = $_SERVER['HTTP_ACCEPT'];
        $accepted_encoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
        $accepted_encoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
        $user_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        // used for api-like response
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($_SERVER);
    }
}