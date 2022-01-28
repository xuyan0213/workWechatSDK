<?php


namespace WorkWechatSdk\Kernel\Events;

use WorkWechatSdk\Kernel\ServiceContainer;


class ApplicationInitialized
{
    /**
     * @var ServiceContainer
     */
    public ServiceContainer $app;

    /**
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }
}