<?php


namespace WorkWechatSdk\WeWork\User;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['user'] = function ($app) {
            return new Client($app);
        };

        $app['user_tag'] = function ($app) {
            return new TagClient($app);
        };

        $app['batch_jobs'] = function ($app) {
            return new BatchJobsClient($app);
        };

        $app['department'] = function ($app) {
            return new DepartmentClient($app);
        };
    }
}
