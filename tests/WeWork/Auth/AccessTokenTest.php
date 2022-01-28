<?php

namespace WorkWechatSdk\Tests\WeWork\Auth;

use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Kernel\ServiceContainer;
use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\Auth\AccessToken;

class AccessTokenTest extends TestCase
{
    public function testGetCredentials()
    {
        $app = new ServiceContainer([
            'corp_id' => '1234',
            'secret' => 'secret',
        ]);
        $accessToken = \Mockery::mock(AccessToken::class, [$app])->makePartial()->shouldAllowMockingProtectedMethods();

        $this->assertSame([
            'corpid' => '1234',
            'corpsecret' => 'secret',
        ], $accessToken->getCredentials());
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function testGetEndpoint()
    {
        $this->assertSame('cgi-bin/gettoken', (new AccessToken(new ServiceContainer()))->getEndpoint());
    }
}