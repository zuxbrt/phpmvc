<?php

namespace Core\Response;

class Status
{
    /**
     * Get requested resource from url.
     * https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     */
    public static function getMessage(int $status_code)
    {
        switch ($status_code) {

            // Information responses
            case 100:
                return 'Continue';
            break;

            case 101:
                return 'Switching Protocol';
            break;

            case 103:
                return 'Early hints.';
            break;


            
            // Successful responses
            case 200:
                return 'OK';
            break;
        
            case 201:
                return 'Created';
            break;

            case 202:
                return 'Accepted';
            break;

            case 203:
                return 'Non-Authoritative Information';
            break;

            case 204:
                return 'No Content';
            break;
        
            case 205:
                return 'Reset Content';
            break;

            case 206:
                return 'Partial Content';
            break;

            
            
            // Redirection messages
            case 300:
                return 'Multiple Choice';
            break;
        
            case 301:
                return 'Moved Permanently';
            break;

            case 302:
                return 'Found';
            break;

            case 303:
                return 'See Other';
            break;

            case 304:
                return 'Not Modified';
            break;
        
            case 307:
                return 'Temporary Redirect';
            break;

            case 308:
                return 'Permanent Redirect';
            break;



            // Client error responses
            case 400:
                return 'Bad request';
            break;
        
            case 401:
                return 'Unauthorized';
            break;

            case 402:
                return 'Payment Required';
            break;

            case 403:
                return 'Forbidden';
            break;

            case 404:
                return 'Not Found';
            break;
        
            case 405:
                return 'Method Not Allowed';
            break;

            case 406:
                return 'Not Acceptable';
            break;

            case 407:
                return 'Proxy Authentication Required';
            break;
            
            case 408:
                return 'Request Timeout';
            break;

            case 409:
                return 'Conflict';
            break;

            case 410:
                return 'Gone';
            break;

            case 411:
                return 'Length Required';
            break;

            case 412:
                return 'Precondition Failed';
            break;

            case 413:
                return 'Payload Too Large';
            break;

            case 414: 
                return 'URI Too Long';
            break;

            case 415:
                return 'Unsupported Media Type';
            break;

            case 416:
                return 'Range Not Satisfiable';
            break;

            case 417:
                return 'Expectation Failed';
            break; 

            case 418:
                return "I'm a teapot";
            break;

            case 426:
                return 'Upgrade Required';
            break;

            case 428:
                return 'Precondition Required';
            break;

            case 429:
                return 'Too Many Requests';
            break;

            case 431: 
                return 'Request Header Fields Too Large';
            break;

            case 451:
                return 'Unavailable For Legal Reasons';
            break;



            // Server error responses
            case 500:
                return 'Internal Server Error';
            break;

            case 501:
                return 'Not Implemented';
            break;

            case 502:
                return 'Bad Gateway';
            break;

            case 503:
                return 'Service Unavailable';
            break;

            case 504:
                return 'Gateway Timeout';
            break;

            case 505:
                return 'HTTP Version Not Supported';
            break;

            case 506:
                return 'Variant Also Negotiates';
            break;

            case 510:
                return 'Not Extended';
            break;

            case 511:
                return 'Network Authentication Required';
            break;

            default:
                break;
        }
    }
}