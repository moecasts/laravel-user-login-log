<?php

namespace Moecasts\Laravel\UserLoginLog\Test;

use Moecasts\Laravel\UserLoginLog\Test\Models\User;
use Moecasts\Laravel\UserLoginLog\Test\TestCase;

class UserLoginLogTest extends TestCase
{

    public function testLoggable()
    {
        $user = User::firstOrCreate(['name' => 'Demo']);

        $log = $user->logLogin();

        $this->assertEquals($log->loggable->name, $user->name);
    }

    public function testGetDeviceTypeAttribute()
    {
        $user = User::firstOrCreate(['name' => 'Demo']);
        $log = $user->logLogin();

        $log->update(['device_type' => 1]);
        $this->assertEquals('DESKTOP', $log->device_type);

        $log->update(['device_type' => 2]);
        $this->assertEquals('TABLET', $log->device_type);


        $log->update(['device_type' => 3]);
        $this->assertEquals('PHONE', $log->device_type);

        $log->update(['device_type' => 4]);
        $this->assertEquals('ROBOT', $log->device_type);
    }
}
