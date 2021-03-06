<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\OpenWeWork\Auth;

use  WorkWechatSdk\Kernel\AccessToken as BaseAccessToken;


class AccessToken extends BaseAccessToken
{
    protected $requestMethod = 'POST';

    /**
     * @var string
     */
    protected $endpointToGetToken = 'cgi-bin/service/get_provider_token';

    /**
     * @var string
     */
    protected $tokenKey = 'provider_access_token';

    /**
     * @var string
     */
    protected $cachePrefix = 'WorkWechatSdk.kernel.provider_access_token.';

    /**
     * Credential for get token.
     *
     * @return array
     */
    protected function getCredentials(): array
    {
        return [
            'corpid' => $this->app['config']['corp_id'], //服务商的corpid
            'provider_secret' => $this->app['config']['secret'],
        ];
    }
}
