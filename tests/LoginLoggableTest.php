<?php

namespace Moecasts\Laravel\UserLoginLog\Test;

use Carbon\Carbon;
use Moecasts\Laravel\UserLoginLog\Models\UserLoginLog;
use Moecasts\Laravel\UserLoginLog\Test\Models\User;
use Moecasts\Laravel\UserLoginLog\Test\TestCase;

class LoginLoggableTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testLogLogin()
    {
        $user = User::firstOrCreate(['name' => 'Demo']);

        $log = $user->logLogin();
        $this->assertEquals($log->getKey(), $user->loginLogs()->first()->getKey());

        $this->assertNull($user->logLogin());
    }

    public function testLoginLogs()
    {
        $user = User::firstOrCreate(['name' => 'Demo']);

        $log = new UserLoginLog([
            'ip' => request()->ip(),
            'device' => 'test',
            'platform' => 'test',
            'browser' => 'test',
            'platform_version' => 'test',
            'browser_version' => 'test',
            'device_type' => 1,
            'login_at' => Carbon::now(),
        ]);

        $user->loginLogs()->saveMany([$log]);

        $logKeys = $user->loginLogs->pluck('id')->toArray();

        $this->assertEquals($logKeys, [$log->getKey()]);
    }

    public function testCreateLoginLog()
    {
        $user = User::firstOrCreate(['name' => 'Demo']);

        $log = $user->createLoginLog();

        $logKeys = $user->loginLogs->pluck('id')->toArray();

        $this->assertEquals($logKeys, [$log->getKey()]);
    }

    public function testIsNewLogin()
    {
        $user = User::firstOrCreate(['name' => 'Demo']);

        $this->assertTrue($user->isNewLogin());

        $user->logLogin();

        $this->assertFalse($user->isNewLogin());
    }
}
