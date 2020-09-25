<?php

namespace Core;

use Core\Response\Status;

class Response
{
    /**
     * Return response.
     * 
     * @param $data
     * @param $status
     */
    public static function send($data, int $status)
    {
        // set headers for json response
        header("Content-Type: application/json; charset=UTF-8");
        
        // echo response
        echo json_encode([
            'status' => $status,
            'message' => Status::getMessage($status),
            'data' => $data
        ]);
    }
}