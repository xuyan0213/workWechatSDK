<?php


namespace WorkWechatSdk\Kernel\Events;

use WorkWechatSdk\Kernel\AccessToken;

class AccessTokenRefreshed
{
    /**
     * @var AccessToken
     */
    public $accessToken;

    /**
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
