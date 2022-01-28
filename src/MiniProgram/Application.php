<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\MiniProgram;

use WorkWechatSdk\BasicService;
use WorkWechatSdk\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 *
 * @property \WorkWechatSdk\MiniProgram\Auth\AccessToken           $access_token
 * @property \WorkWechatSdk\MiniProgram\DataCube\Client            $data_cube
 * @property \WorkWechatSdk\MiniProgram\AppCode\Client             $app_code
 * @property \WorkWechatSdk\MiniProgram\Auth\Client                $auth
 * @property \WorkWechatSdk\OfficialAccount\Server\Guard           $server
 * @property \WorkWechatSdk\MiniProgram\Encryptor                  $encryptor
 * @property \WorkWechatSdk\MiniProgram\TemplateMessage\Client     $template_message
 * @property \WorkWechatSdk\OfficialAccount\CustomerService\Client $customer_service
 * @property \WorkWechatSdk\MiniProgram\Plugin\Client              $plugin
 * @property \WorkWechatSdk\MiniProgram\Plugin\DevClient           $plugin_dev
 * @property \WorkWechatSdk\MiniProgram\UniformMessage\Client      $uniform_message
 * @property \WorkWechatSdk\MiniProgram\ActivityMessage\Client     $activity_message
 * @property \WorkWechatSdk\MiniProgram\Express\Client             $logistics
 * @property \WorkWechatSdk\MiniProgram\NearbyPoi\Client           $nearby_poi
 * @property \WorkWechatSdk\MiniProgram\OCR\Client                 $ocr
 * @property \WorkWechatSdk\MiniProgram\Soter\Client               $soter
 * @property \WorkWechatSdk\BasicService\Media\Client              $media
 * @property \WorkWechatSdk\BasicService\ContentSecurity\Client    $content_security
 * @property \WorkWechatSdk\MiniProgram\Mall\ForwardsMall          $mall
 * @property \WorkWechatSdk\MiniProgram\SubscribeMessage\Client    $subscribe_message
 * @property \WorkWechatSdk\MiniProgram\RealtimeLog\Client         $realtime_log
 * @property \WorkWechatSdk\MiniProgram\RiskControl\Client         $risk_control
 * @property \WorkWechatSdk\MiniProgram\Search\Client              $search
 * @property \WorkWechatSdk\MiniProgram\Live\Client                $live
 * @property \WorkWechatSdk\MiniProgram\Broadcast\Client           $broadcast
 * @property \WorkWechatSdk\MiniProgram\UrlScheme\Client           $url_scheme
 * @property \WorkWechatSdk\MiniProgram\Union\Client               $union
 * @property \WorkWechatSdk\MiniProgram\Shop\Register\Client       $shop_register
 * @property \WorkWechatSdk\MiniProgram\Shop\Basic\Client          $shop_basic
 * @property \WorkWechatSdk\MiniProgram\Shop\Account\Client        $shop_account
 * @property \WorkWechatSdk\MiniProgram\Shop\Spu\Client            $shop_spu
 * @property \WorkWechatSdk\MiniProgram\Shop\Order\Client          $shop_order
 * @property \WorkWechatSdk\MiniProgram\Shop\Delivery\Client       $shop_delivery
 * @property \WorkWechatSdk\MiniProgram\Shop\Aftersale\Client      $shop_aftersale
 * @property \WorkWechatSdk\MiniProgram\Business\Client            $business
 * @property \WorkWechatSdk\MiniProgram\UrlLink\Client             $url_link
 * @property \WorkWechatSdk\MiniProgram\QrCode\Client              $qr_code
 * @property \WorkWechatSdk\MiniProgram\PhoneNumber\Client         $phone_number
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected array $providers = [
        Auth\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        Server\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        UniformMessage\ServiceProvider::class,
        ActivityMessage\ServiceProvider::class,
        OpenData\ServiceProvider::class,
        Plugin\ServiceProvider::class,
        QrCode\ServiceProvider::class,
        Base\ServiceProvider::class,
        Express\ServiceProvider::class,
        NearbyPoi\ServiceProvider::class,
        OCR\ServiceProvider::class,
        Soter\ServiceProvider::class,
        Mall\ServiceProvider::class,
        SubscribeMessage\ServiceProvider::class,
        RealtimeLog\ServiceProvider::class,
        RiskControl\ServiceProvider::class,
        Search\ServiceProvider::class,
        Live\ServiceProvider::class,
        Broadcast\ServiceProvider::class,
        UrlScheme\ServiceProvider::class,
        UrlLink\ServiceProvider::class,
        Union\ServiceProvider::class,
        PhoneNumber\ServiceProvider::class,
        // Base services
        BasicService\Media\ServiceProvider::class,
        BasicService\ContentSecurity\ServiceProvider::class,

        Shop\Register\ServiceProvider::class,
        Shop\Basic\ServiceProvider::class,
        Shop\Account\ServiceProvider::class,
        Shop\Spu\ServiceProvider::class,
        Shop\Order\ServiceProvider::class,
        Shop\Delivery\ServiceProvider::class,
        Shop\Aftersale\ServiceProvider::class,
        Business\ServiceProvider::class,
    ];

    /**
     * Handle dynamic calls.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->base->$method(...$args);
    }
}
