<?php

namespace Moecasts\Laravel\UserLoginLog\Test;

use Jenssegers\Agent\Agent;
use Moecasts\Laravel\UserLoginLog\DeviceType;
use Moecasts\Laravel\UserLoginLog\Test\Models\User;
use Moecasts\Laravel\UserLoginLog\Test\TestCase;
use function app;

class DeciveTypeTest extends TestCase
{
    public function testGetType()
    {
        $class = new \ReflectionClass(DeviceType::class);

        $types = $class->getConstants();

        foreach ($types as $type => $value) {
            $this->assertEquals($type, DeviceType::getType($value));
        }
    }

    public function testGetValue()
    {
        $agent = new Agent();

        $agent->setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2');
        $this->assertEquals(DeviceType::DESKTOP, DeviceType::getValue($agent));

        $agent->setUserAgent('Mozilla/5.0 (iPad; U; CPU OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5');
        $this->assertEquals(DeviceType::TABLET, DeviceType::getValue($agent));

        $agent->setUserAgent('Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5');
        $this->assertEquals(DeviceType::PHONE, DeviceType::getValue($agent));

        $agent->setUserAgent('Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
        $this->assertEquals(DeviceType::ROBOT, DeviceType::getValue($agent));
    }
}
