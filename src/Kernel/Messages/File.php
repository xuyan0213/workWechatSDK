<?php


namespace WorkWechatSdk\Kernel\Messages;

/**
 * 文件消息.
 *
 * @property string $media_id
 */
class File extends Media
{
    /**
     * @var string
     */
    protected $type = 'file';
}
