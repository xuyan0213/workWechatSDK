<?php

namespace WorkWechatSdk\WeWork\Auth;

use WorkWechatSdk\Kernel\AccessToken as BaseAccessToken;

/**
 * AccessToken.
 *
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @var string
     */
    protected $endpointToGetToken = 'cgi-bin/gettoken';

    /**
     * @var int
     */
    protected int $safeSeconds = 0;

    /**
     * 通过secret获取accessToken
     *
     * @return array
     */
    protected function getCredentials(): array
    {
        return [
            'corpid' => $this->app['config']['corp_id'],
            'corpsecret' => $this->app['config']['secret'],
        ];
    }
}
