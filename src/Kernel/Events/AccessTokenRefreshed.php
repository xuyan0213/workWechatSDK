<?php


namespace WorkWechatSdk\Kernel\Events;

use WorkWechatSdk\Kernel\AccessToken;

class AccessTokenRefreshed
{
    /**
     * @var AccessToken
     */
    public AccessToken $accessToken;

    /**
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
