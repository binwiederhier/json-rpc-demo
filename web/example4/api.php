<?php

require_once '../../vendor/autoload.php';

use Datto\JsonRpc;
use Datto\JsonRpc\Auth;
use Datto\JsonRpc\Simple;
use Datto\JsonRpc\Logged;
use Datto\JsonRpc\Validator;
use Demo\Api\Auth\BasicAuthHandler;
use Monolog\Handler\SyslogHandler;
use Monolog\Logger;

$authenticator = new Auth\Authenticator(array(
    new BasicAuthHandler()
));

$mapper = new Simple\Mapper('Demo\\Api\\Endpoint\\');
$logger = new Logger('demo.api', array(new SyslogHandler('api')));

$evaluator = new Auth\Evaluator(new Validator\Evaluator(new Simple\Evaluator($mapper), $mapper), $authenticator);
$server = new Logged\Server($evaluator, $logger);

header('Content-Type: application/json');
$message = file_get_contents('php://input');

echo $server->reply($message);
