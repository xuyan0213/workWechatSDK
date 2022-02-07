<?php

namespace WorkWechatSdk\WeWork\OAuth;

use WorkWechatSdk\WeWork\Application;
use Overtrue\Socialite\AccessTokenInterface;

/**
 * @method $this scopes(array $scopes)
 * @method $this setAgentId(string $agentId)
 */
class Manager implements AccessTokenInterface
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * 返回access_token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->app['access_token']->getToken()['access_token'];
    }
}
