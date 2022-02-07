<?php


namespace WorkWechatSdk\WeWork\Server\Handlers;

use WorkWechatSdk\Kernel\Contracts\EventHandlerInterface;
use WorkWechatSdk\Kernel\Decorators\FinallyResult;
use WorkWechatSdk\Kernel\ServiceContainer;

class EchoStrHandler implements EventHandlerInterface
{
    /**
     * @var ServiceContainer
     */
    protected $app;

    /**
     * EchoStrHandler constructor.
     *
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param mixed $payload
     *
     * @return FinallyResult|null
     */
    public function handle($payload = null)
    {
        if ($decrypted = $this->app['request']->get('echostr')) {
            $str = $this->app['encryptor']->decrypt(
                $decrypted,
                $this->app['request']->get('msg_signature'),
                $this->app['request']->get('nonce'),
                $this->app['request']->get('timestamp')
            );

            return new FinallyResult($str);
        }

        return null;
    }
}
