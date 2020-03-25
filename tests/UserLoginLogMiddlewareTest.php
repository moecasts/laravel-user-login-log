<?php

namespace Moecasts\Laravel\UserLoginLog\Test;

use Moecasts\Laravel\UserLoginLog\Middleware\UserLoginLogMiddleware;
use Moecasts\Laravel\UserLoginLog\Test\Models\User;
use Moecasts\Laravel\UserLoginLog\Test\TestCase;

class UserLoginLogMiddlewareTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('loginlog.expire', 1);
        $this->app['router']->get('hello', [
            'middleware' => UserLoginLogMiddleware::class,
            'uses' => function () {
                return 'hello world';
            },
        ]);
    }

    public function testUnauthenticatedRequest()
    {
        $user = User::create(['name' => 'Demo']);

        $response = $this
            ->call('GET', 'hello');

        $this->assertGuest();
    }

    public function testAuthenticatedRequest()
    {
        $user = User::create(['name' => 'Demo']);

        $this
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2'])
            ->actingAs($user)
            ->call('GET', 'hello');

        $this->assertAuthenticated();
        $this->assertCount(1, $user->loginLogs()->get());

        $this->call('GET', 'hello');
        $this->assertAuthenticated();
        $this->assertCount(1, $user->loginLogs()->get());

        sleep(2);

        $this->call('GET', 'hello');
        $this->assertAuthenticated();
        $this->assertCount(2, $user->loginLogs()->get());
    }
}
