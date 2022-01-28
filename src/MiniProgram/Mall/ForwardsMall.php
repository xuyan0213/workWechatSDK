<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\MiniProgram\Mall;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \WorkWechatSdk\MiniProgram\Mall\OrderClient   $order
 * @property \WorkWechatSdk\MiniProgram\Mall\CartClient    $cart
 * @property \WorkWechatSdk\MiniProgram\Mall\ProductClient $product
 * @property \WorkWechatSdk\MiniProgram\Mall\MediaClient   $media
 */
class ForwardsMall
{
    /**
     * @var \WorkWechatSdk\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * @param \WorkWechatSdk\Kernel\ServiceContainer $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->app["mall.{$property}"];
    }
}
