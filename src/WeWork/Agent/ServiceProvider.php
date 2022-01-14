<?php

namespace WorkWechatSdk\WeWork\Agent;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['agent'] = function ($app) {
            return new Client($app);
        };

        $app['agent_workbench'] = function ($app) {
            return new WorkbenchClient($app);
        };
    }
}
