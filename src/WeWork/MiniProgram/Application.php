<?php


namespace WorkWechatSdk\WeWork\MiniProgram;

use WorkWechatSdk\MiniProgram\Application as MiniProgram;
use WorkWechatSdk\WeWork\Auth\AccessToken;
use WorkWechatSdk\WeWork\MiniProgram\Auth\Client;


class Application extends MiniProgram
{
    /**
     * Application constructor.
     *
     * @param array $config
     * @param array $prepends
     */
    public function __construct(array $config = [], array $prepends = [])
    {
        parent::__construct($config, $prepends + [
            'access_token' => function ($app) {
                return new AccessToken($app);
            },
            'auth' => function ($app) {
                return new Client($app);
            },
        ]);
    }
}
