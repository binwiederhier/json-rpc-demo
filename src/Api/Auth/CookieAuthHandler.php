<?php

namespace Demo\Api\Auth;

use Datto\JsonRpc\Auth;

class CookieAuthHandler implements Auth\Handler
{
    public function canHandle($method, $arguments)
    {
        return isset($_COOKIE['token']);
    }

    public function authenticate($method, $arguments)
    {
        return $_COOKIE['token'] === 'secret';
    }
}
