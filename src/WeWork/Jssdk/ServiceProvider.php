<?php

namespace WorkWechatSdk\WeWork\Jssdk;

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
        $app['jssdk'] = function ($app) {
            return new Client($app);
        };
    }
}
