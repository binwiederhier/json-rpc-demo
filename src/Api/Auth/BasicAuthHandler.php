<?php

namespace Demo\Api\Auth;

use Datto\JsonRpc\Auth;

class BasicAuthHandler implements Auth\Handler
{
    public function canHandle($method, $arguments)
    {
        return isset($_SERVER['PHP_AUTH_USER']);
    }

    public function authenticate($method, $arguments)
    {
        return $_SERVER['PHP_AUTH_USER'] === 'user' 
            && $_SERVER['PHP_AUTH_PW'] === 'pass';
    }
}
