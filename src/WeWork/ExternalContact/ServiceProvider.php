<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\WeWork\ExternalContact;

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

        // 企业服务人员管理
        $app['contact_way'] = function ($app) {
            return new ContactWayClient($app);
        };
        // 客户管理
        $app['external_contact'] = function ($app) {
            return new Client($app);
        };

        // 客户群管理
        $app['group_chat'] = function ($app) {
            return new GroupChatClient($app);
        };

        // 离职/在职继承
        $app['transfer_customer'] = function ($app) {
            return new TransferCustomerClient($app);
        };

        //消息推送
        $app['group_send'] = function ($app) {
            return new MessageClient($app);
        };

        //朋友圈
        $app['moment'] = function ($app) {
            return new MomentClient($app);
        };

        //统计
        $app['statistics'] = function ($app) {
            return new StatisticsClient($app);
        };

        //标签
        $app['external_contact_tag'] = function ($app) {
            return new TagClient($app);
        };
    }
}
