<?php

namespace Core\Error;

class ErrorResponse
{
    /**
     * Return prettier response in browser 
     * - wrap it in styled HTML instead of simple php's die();
     */
    public function returnMessage($type, $message)
    {
        switch ($type) {
            case 'error':
                $color = 'red';
                $text = 'Error:';
                break;
            
            case 'warning':
                $color = 'yellow';
                $text = 'Warning:';
                break;

            case 'info':
                $color = 'white';
                $text = 'Info:';
                break;
        }
        $message = 
        "<div style='background: black;color:white; font-family: Lucida Console, Monaco, monospace; padding: 5px;display: flex;flex-direction: row;'>"
            ."<p style='color:$color; margin: 0'>" . $text . "</p>" . "&nbsp" . $message.
        "</div>";

        die($message);
    }
}