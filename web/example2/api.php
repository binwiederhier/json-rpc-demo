<?php

require_once '../../vendor/autoload.php';

use Datto\JsonRpc;
use Datto\JsonRpc\Simple;
use Datto\JsonRpc\Validator;

$mapper = new Simple\Mapper('Demo\\Api\\Endpoint\\');

$evaluator = new Validator\Evaluator(new Simple\Evaluator($mapper), $mapper);
$server = new JsonRpc\Server($evaluator);

header('Content-Type: application/json');
$message = file_get_contents('php://input');

echo $server->reply($message);


