<?php

namespace Core;

class Response
{
    public function send($data)
    {
        header("Content-Type: application/json; charset=UTF-8");
        
        echo json_encode([
            'status' => 200,
            'message' => 'Success',
            'data' => $data
        ]);
    }
}