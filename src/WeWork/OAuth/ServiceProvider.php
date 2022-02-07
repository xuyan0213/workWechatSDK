<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\WeWork\OAuth;

use Overtrue\Socialite\SocialiteManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * 注册服务,同时把容器中的配置信息配置到OAuth中
     * @param Container $app
     * @return void
     */
    public function register(Container $app)
    {
        $app['oauth'] = function ($app) {
            $socialite = (new SocialiteManager([
                'wework' => [
                    'base_url' => $app['config']['http']['base_uri'],
                    'client_id' => $app['config']['corp_id'],
                    'client_secret' => null,
                    'corp_id' => $app['config']['corp_id'],
                    'corp_secret' => $app['config']['secret'],
                    'redirect' => $this->prepareCallbackUrl($app),
                ],
            ], $app));

            $scopes = (array) $app['config']->get('oauth.scopes', ['snsapi_base']);

            if (!empty($scopes)) {
                $socialite->scopes($scopes);
            } else {
                $socialite->setAgentId($app['config']['agent_id']);
            }

            return $socialite;
        };
    }

    /**
     * 准备企微 OAuth 回调地址.
     *
     * @param Container $app
     *
     * @return string
     */
    private function prepareCallbackUrl(Container $app): string
    {
        $callback = $app['config']->get('oauth.callback');

        if (0 === stripos($callback, 'http')) {
            return $callback;
        }

        $baseUrl = $app['request']->getSchemeAndHttpHost();

        return $baseUrl.'/'.ltrim($callback, '/');
    }
}
