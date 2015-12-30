<?php

require_once '../../vendor/autoload.php';

use Datto\JsonRpc;
use Demo\Api\Evaluator\DevicesEvaluator;

$evaluator = new DevicesEvaluator();
$server = new JsonRpc\Server($evaluator);

header('Content-Type: application/json');
$message = file_get_contents('php://input');

echo $server->reply($message);
