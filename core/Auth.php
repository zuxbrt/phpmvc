<?php

namespace core;

use core\Database\MySql;
use PDO;

class Auth {

    private static $connection;

    public function __construct()
    {

    }

    /**
     * Check if user is authorized in current session.
     */
    static function check()
    {
        // First check if a username was provided.
        if (!isset($_SESSION['PHP_AUTH_USER'])) {
            return false;
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

    /**
     * Log user to current session.
     */
    static function login(array $credentials)
    {
        if(!isset($credentials['username']) || !isset($credentials['password'])){
            return Response::send('Bad parameters', 400);
        }

        $username = $credentials['username'];
        $password = $credentials['password'];

        $mysql = new MySql();
        $connection = $mysql->connect();

        $check_query = "SELECT * FROM users WHERE username='".$username."'";
        $check = $connection->query($check_query);
        $results = $check->fetch(PDO::FETCH_ASSOC);
        if(!empty(($results))){
            
            die('pliz');
            $user_pass = $results['password'];
            if(password_verify($password, $user_pass)){
                $_SESSION["PHP_AUTH_USER"] = $username;
                $_SESSION["PHP_AUTH_PW"] = $user_pass;
                Response::setHeader('Location: /');
                exit;
            } else {
                return Response::send('Incorrect password', 401);
            }
        } else {
            return Response::send('Incorrect login details', 401);
        }

        die(print_r($results));

        //die(print_r($credentials));
        die(print_r(password_hash($credentials['password'], PASSWORD_BCRYPT)));
        session_unset($_SESSION['PHP_AUTH_USER']);
        session_unset($_SESSION['PHP_AUTH_PW']);
    }

    /**
     * Log out user from current session.
     */
    static function logout()
    {
        if(isset(($_SESSION['PHP_AUTH_USER'])) && isset(($_SESSION['PHP_AUTH_PW']))){
            session_unset($_SESSION['PHP_AUTH_USER']);
            session_unset($_SESSION['PHP_AUTH_PW']);
        }
    }
}