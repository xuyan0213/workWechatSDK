<?php


namespace WorkWechatSdk\WeWork\MsgAudit;

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
        $app['msg_audit'] = function ($app) {
            return new Client($app);
        };
    }
}
