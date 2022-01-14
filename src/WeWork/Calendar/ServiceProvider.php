<?php


namespace WorkWechatSdk\WeWork\Calendar;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['calendar'] = function ($app) {
            return new Client($app);
        };
    }
}
