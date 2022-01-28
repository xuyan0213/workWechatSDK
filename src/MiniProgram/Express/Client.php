<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\MiniProgram\Express;

use WorkWechatSdk\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author kehuanhuan <1152018701@qq.com>
 */
class Client extends BaseClient
{
    /**
     * @return \Psr\Http\Message\ResponseInterface|\WorkWechatSdk\Kernel\Support\Collection|array|object|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     */
    public function listProviders()
    {
        return $this->httpGet('cgi-bin/express/business/delivery/getall');
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface|\WorkWechatSdk\Kernel\Support\Collection|array|object|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     */
    public function getAllAccount()
    {
        return $this->httpGet('cgi-bin/express/business/account/getall');
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\WorkWechatSdk\Kernel\Support\Collection|array|object|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createWaybill(array $params = [])
    {
        return $this->httpPostJson('cgi-bin/express/business/order/add', $params);
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\WorkWechatSdk\Kernel\Support\Collection|array|object|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteWaybill(array $params = [])
    {
        return $this->httpPostJson('cgi-bin/express/business/order/cancel', $params);
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\WorkWechatSdk\Kernel\Support\Collection|array|object|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWaybill(array $params = [])
    {
        return $this->httpPostJson('cgi-bin/express/business/order/get', $params);
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\WorkWechatSdk\Kernel\Support\Collection|array|object|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWaybillTrack(array $params = [])
    {
        return $this->httpPostJson('cgi-bin/express/business/path/get', $params);
    }

    /**
     * @param string $deliveryId
     * @param string $bizId
     *
     * @return array|\WorkWechatSdk\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBalance(string $deliveryId, string $bizId)
    {
        return $this->httpPostJson('cgi-bin/express/business/quota/get', [
            'delivery_id' => $deliveryId,
            'biz_id' => $bizId,
        ]);
    }

    /**
     * @return array|\WorkWechatSdk\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPrinter()
    {
        return $this->httpPostJson('cgi-bin/express/business/printer/getall');
    }

    /**
     * @param string $openid
     *
     * @return array|\WorkWechatSdk\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function bindPrinter(string $openid)
    {
        return $this->httpPostJson('cgi-bin/express/business/printer/update', [
            'update_type' => 'bind',
            'openid' => $openid,
        ]);
    }

    /**
     * @param string $openid
     *
     * @return array|\WorkWechatSdk\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \WorkWechatSdk\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function unbindPrinter(string $openid)
    {
        return $this->httpPostJson('cgi-bin/express/business/printer/update', [
            'update_type' => 'unbind',
            'openid' => $openid,
        ]);
    }
}
