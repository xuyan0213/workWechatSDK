<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\MiniProgram\Plugin;

use WorkWechatSdk\Kernel\BaseClient;

/**
 * Class DevClient.
 *
 * @author her-cat <i@her-cat.com>
 */
class DevClient extends BaseClient
{
    /**
     * Get users.
     *
     * @param int $page
     * @param int $size
     *
     * @return array|\WorkWechatSdk\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUsers(int $page = 1, int $size = 10)
    {
        return $this->httpPostJson('wxa/devplugin', [
            'action' => 'dev_apply_list',
            'page' => $page,
            'num' => $size,
        ]);
    }

    /**
     * Agree to use plugin.
     *
     * @param string $appId
     *
     * @return array|\WorkWechatSdk\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function agree(string $appId)
    {
        return $this->httpPostJson('wxa/devplugin', [
            'action' => 'dev_agree',
            'appid' => $appId,
        ]);
    }

    /**
     * Refuse to use plugin.
     *
     * @param string $reason
     *
     * @return array|\WorkWechatSdk\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refuse(string $reason)
    {
        return $this->httpPostJson('wxa/devplugin', [
            'action' => 'dev_refuse',
            'reason' => $reason,
        ]);
    }

    /**
     * Delete rejected applications.
     *
     * @return array|\WorkWechatSdk\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete()
    {
        return $this->httpPostJson('wxa/devplugin', [
            'action' => 'dev_delete',
        ]);
    }
}