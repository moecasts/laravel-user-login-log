<?php

namespace Moecasts\Laravel\UserLoginLog\Test;

use Moecasts\Laravel\UserLoginLog\Cacher;
use Moecasts\Laravel\UserLoginLog\Test\Models\User;
use Moecasts\Laravel\UserLoginLog\Test\TestCase;
use function app;

class CacherTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->cacher = app(Cacher::class);
    }

    public function testSimple()
    {
        $user = User::firstOrCreate(['name' => 'Demo']);

        $key = $this->cacher->getCacheKey($user);
        $content = $this->cacher->getCacheContent($user);

        $this->cacher->setCache($user);

        $this->assertTrue($this->cacher->hasCache($user));
        $cache = $this->cacher->pullCache($user);

        $this->assertFalse($this->cacher->hasCache($user));
        $this->assertEquals($cache['loggable'], $content['loggable']);
    }

    public function testExpiredCache()
    {
        $user = User::firstOrCreate(['name' => 'Demo']);

        $this->cacher->setCache($user, 1);
        $this->assertTrue($this->cacher->hasCache($user));
        sleep(2);
        $this->assertFalse($this->cacher->hasCache($user));
    }
}
