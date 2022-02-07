<?php

namespace WorkWechatSdk\Tests\WeWork\OAuth;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\Kernel\AccessToken;
use WorkWechatSdk\WeWork\Application;
use WorkWechatSdk\WeWork\OAuth\Manager;

class ManagerTest extends TestCase
{

    public function testGetToken()
    {
        $accessToken = \Mockery::mock(AccessToken::class);
        $accessToken->allows()->getToken()->andReturn(['access_token' => 'mock-token']);

        $delegate = new Manager(new Application([], [
            'access_token' => $accessToken,
        ]));

        $this->assertSame('mock-token', $delegate->getToken());
    }
}