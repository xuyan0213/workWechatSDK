<?php


namespace WorkWechatSdk\Kernel\Providers;

use EasyWeChatComposer\Extension;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ExtensionServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $pimple 容器实例
     */
    public function register(Container $pimple)
    {
        $pimple['extension'] = function ($app) {
            return new Extension($app);
        };
    }
}
