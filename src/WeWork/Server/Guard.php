<?php


namespace WorkWechatSdk\WeWork\Server;

use WorkWechatSdk\Kernel\ServerGuard;

class Guard extends ServerGuard
{
    /**
     * @return $this
     */
    public function validate()
    {
        return $this;
    }

    /**
     * Check the request message safe mode.
     *
     * @return bool
     */
    protected function isSafeMode(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    protected function shouldReturnRawResponse(): bool
    {
        return !is_null($this->app['request']->get('echostr'));
    }
}
