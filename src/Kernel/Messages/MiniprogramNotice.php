<?php

namespace WorkWechatSdk\Kernel\Messages;

/**
 * 小程序通知消息
 */
class MiniprogramNotice extends Message
{
    protected $type = 'miniprogram_notice';

    protected $properties = [
        'appid',
        'title',
    ];
}
