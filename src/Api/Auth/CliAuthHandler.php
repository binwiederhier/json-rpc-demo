<?php

namespace Demo\Api\Auth;

use Datto\JsonRpc\Auth;

class CliAuthHandler implements Auth\Handler
{
    public function canHandle($method, $arguments)
    {
        return php_sapi_name() === 'cli';
    }

    public function authenticate($method, $arguments)
    {
        return posix_getuid() === 0; // Only run as 'root'!
    }
}
