<?php

namespace Demo\Api\Endpoint;

use Datto\JsonRpc\Validator\Validate;
use Demo\Device\DeviceManager;
use Symfony\Component\Validator\Constraints as Assert;

class Devices
{
    private $devices;

    public function __construct()
    {
        $this->devices = new DeviceManager();
    }

    /**
     * @Validate(fields={
     *   "name" = { @Assert\Type(type="string"), @Assert\NotBlank() },
     *   "type" = { @Assert\Regex("/^(pc|mac|phone|other)$/") },
     *   "id" = { @Assert\Type(type="integer"), @Assert\Range(min=0, max=100) }
     * })
     */
    public function add($name, $id = 0, $type = 'other')
    {
        return $this->devices->add($id, $name, $type);
    }

    /**
     * @Validate(fields={
     *   "sortBy" = { @Assert\Regex("/^(id|name|type)$/") }
     * })
     */
    public function listAll($sortBy = 'name')
    {
        return $this->devices->listAll($sortBy);
    }
}

