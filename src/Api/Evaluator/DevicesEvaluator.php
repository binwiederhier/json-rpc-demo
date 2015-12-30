<?php

namespace Demo\Api\Evaluator;

use Datto\JsonRpc;
use Datto\JsonRpc\Exception;
use Demo\Device\DeviceManager;

class DevicesEvaluator implements JsonRpc\Evaluator
{
    private $devices;

    public function __construct()
    {
        $this->devices = new DeviceManager();
    }

    public function evaluate($method, $arguments)
    {
        if ($method === 'devices/add') {
            return $this->devices->add($arguments['id'], $arguments['name'], $arguments['type']);
        } else if ($method === 'devices/listAll') {
            return $this->devices->listAll($arguments['sortBy']);
        }else {
            throw new Exception\Method();
        }
    }
}