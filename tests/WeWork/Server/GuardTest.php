<?php

namespace WorkWechatSdk\Tests\WeWork\Server;

use WorkWechatSdk\Kernel\ServiceContainer;
use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\Server\Guard;
use Symfony\Component\HttpFoundation\Request;

class GuardTest extends TestCase
{
    public function testValidate()
    {
        $guard = \Mockery::mock(Guard::class)->makePartial();
        $this->assertSame($guard, $guard->validate());
    }

    public function testShouldReturnRawResponse()
    {
        $app = new ServiceContainer([], [
            'request' => Request::create('/path/to/resource?echostr=foo'),
        ]);
        $guard = \Mockery::mock(Guard::class, [$app])->makePartial();
        $this->assertTrue($guard->shouldReturnRawResponse());

        $app = new ServiceContainer([], [
            'request' => Request::create('/path/to/resource?foo=bar'),
        ]);
        $guard = \Mockery::mock(Guard::class, [$app])->makePartial();
        $this->assertFalse($guard->shouldReturnRawResponse());
    }

    public function testIsSafeMode()
    {
        $guard = \Mockery::mock(Guard::class, [new ServiceContainer()])->makePartial();
        $method = new \ReflectionMethod($guard, 'isSafeMode');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($guard));
    }
}