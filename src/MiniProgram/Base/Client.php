<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\MiniProgram\Base;

use WorkWechatSdk\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * Get paid unionid.
     *
     * @param string $openid
     * @param array  $options
     *
     * @return \Psr\Http\Message\ResponseInterface|\WorkWechatSdk\Kernel\Support\Collection|array|object|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPaidUnionid($openid, $options = [])
    {
        return $this->httpGet('wxa/getpaidunionid', compact('openid') + $options);
    }
}
