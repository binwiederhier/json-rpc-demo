<?php

namespace Demo\Device;

use Datto\JsonRpc\Validator\Validate;
use Symfony\Component\Validator\Constraints as Assert;

class DeviceManager
{
    const USER_FILE = '/tmp/devices';

    private $devicesFile;
    private $devices;

    public function __construct($usersFile = self::USER_FILE)
    {
        $this->devicesFile = $usersFile;
        $this->devices = $this->load();
    }

    public function __destruct()
    {
        $this->save();
    }

    public function add($id, $name, $type)
    {
        $device = array(
            'id' => $id,
            'name' => $name,
            'type' => $type,
        );

        $this->devices[] = $device;
        return $device;
    }

    public function listAll($sortBy)
    {
        if ($sortBy === 'id') {
            usort($this->devices, function ($u1, $u2) use ($sortBy) {
                return $u1[$sortBy] - $u2[$sortBy];
            });
        } else if ($sortBy === 'type' || $sortBy === 'name') {
            usort($this->devices, function ($u1, $u2) use ($sortBy) {
                return strcmp($u1[$sortBy], $u2[$sortBy]);
            });
        }

        return $this->devices;
    }

    private function load()
    {
        if (file_exists($this->devicesFile)) {
            return json_decode(file_get_contents($this->devicesFile), true);
        } else {
            return array();
        }
    }

    private function save()
    {
        file_put_contents($this->devicesFile, json_encode($this->devices));
        @chmod($this->devicesFile, 0666);
    }
}

