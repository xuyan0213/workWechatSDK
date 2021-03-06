<?php


namespace WorkWechatSdk\Kernel\Providers;

use WorkWechatSdk\Kernel\Config;
use Pimple\Container;
use Pimple\ServiceProviderInterface;


class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $pimple 容器实例
     */
    public function register(Container $pimple)
    {
        $pimple['config'] = function ($app) {
            return new Config($app->getConfig());
        };
    }
}
