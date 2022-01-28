<?php


namespace WorkWechatSdk\WeWork\Message;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['message'] = function ($app) {
            return new Client($app);
        };

        $app['messenger'] = function ($app) {
            $messenger = new Messenger($app['message']);

            if (is_numeric($app['config']['agent_id'])) {
                $messenger->ofAgent($app['config']['agent_id']);
            }

            return $messenger;
        };
    }
}
