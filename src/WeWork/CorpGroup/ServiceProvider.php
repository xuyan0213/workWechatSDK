<?php


namespace WorkWechatSdk\WeWork\CorpGroup;

use Pimple\Container;
use Pimple\ServiceProviderInterface;


class ServiceProvider implements ServiceProviderInterface
{
    protected $app;

    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['corp_group'] = function ($app) {
            return new Client($app);
        };
    }
}
