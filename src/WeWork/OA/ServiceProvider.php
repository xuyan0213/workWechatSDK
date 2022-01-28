<?php

namespace WorkWechatSdk\WeWork\OA;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['oa'] = function ($app) {
            return new CalendarClient($app);
        };
        $app['checkin'] = function ($app) {
            return new CheckinClient($app);
        };
        $app['calendar'] = function ($app) {
            return new CalendarClient($app);
        };
    }
}
