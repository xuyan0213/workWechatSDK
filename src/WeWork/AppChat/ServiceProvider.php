<?php


namespace WorkWechatSdk\WeWork\AppChat;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 *
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['app_chat'] = function ($app) {
            return new Client($app);
        };
    }
}
