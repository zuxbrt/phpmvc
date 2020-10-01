<?php

namespace core;

class Auth {

    public function __construct()
    {
        
    }

    static function check()
    {
        // session_unset($_SESSION['PHP_AUTH_USER']);
        // session_unset($_SESSION['PHP_AUTH_PW']);

        // First check if a username was provided.
        if (!isset($_SESSION['PHP_AUTH_USER'])) {
            echo 'Not logged in';
            // If no username provided, present the auth challenge.
            // header('WWW-Authenticate: Basic realm="My Website"');
            // header('HTTP/1.0 401 Unauthorized');
            // User will be presented with the username/password prompt
            // If they hit cancel, they will see this access denied message.
            //echo '<p>Access denied. You did not enter a password.</p>';
            //exit; // Be safe and ensure no other content is returned.
        }

        // If we get here, username was provided. Check password.
        // if ($_SESSION['PHP_AUTH_PW'] == '$ecret') {
        //     echo '<p>Access granted. You know the password!</p>';
        // } else {
        //     echo '<p>Access denied! You do not know the password.</p>';
        // }
    }
}