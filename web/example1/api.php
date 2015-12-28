<?php

require_once '../../vendor/autoload.php';

use Datto\JsonRpc;
use Datto\JsonRpc\Simple;

$evaluator = new Simple\Evaluator(new Simple\Mapper('Demo\\Api\\Endpoint\\'));
$server = new JsonRpc\Server($evaluator);

header('Content-Type: application/json');
$message = file_get_contents('php://input');

echo $server->reply($message);
