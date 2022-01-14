<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\Kernel;

use WorkWechatSdk\Kernel\Contracts\Arrayable;
use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Kernel\Exceptions\RuntimeException;
use WorkWechatSdk\Kernel\Support\Arr;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * @throws RuntimeException
 */
function data_get($data, $key, $default = null)
{
    switch (true) {
        case is_array($data):
            return Arr::get($data, $key, $default);
        case $data instanceof Collection:
            return $data->get($key, $default);
        case $data instanceof Arrayable:
            return Arr::get($data->toArray(), $key, $default);
        case $data instanceof \ArrayIterator:
            return $data->getArrayCopy()[$key] ?? $default;
        case $data instanceof \ArrayAccess:
            return $data[$key] ?? $default;
        case $data instanceof \IteratorAggregate && $data->getIterator() instanceof \ArrayIterator:
            return $data->getIterator()->getArrayCopy()[$key] ?? $default;
        case is_object($data):
            return $data->{$key} ?? $default;
        default:
            throw new RuntimeException(sprintf('Can\'t access data with key "%s"', $key));
    }
}

/**
 * @throws RuntimeException
 */
function data_to_array($data): array
{
    switch (true) {
        case is_array($data):
            return $data;
        case $data instanceof Collection:
            return $data->all();
        case $data instanceof Arrayable:
            return $data->toArray();
        case $data instanceof \IteratorAggregate && $data->getIterator() instanceof \ArrayIterator:
            return $data->getIterator()->getArrayCopy();
        case $data instanceof \ArrayIterator:
            return $data->getArrayCopy();
        default:
            throw new RuntimeException('Can\'t transform data to array');
    }
}

class Helpers
{
    private static $types;
    private static $image;
    private static $link;
    private static $miniprogram;
    private static $video;
    private static $file;

    /**
     * 附件类型
     * @param $type string moment:朋友圈 welcome:欢迎语
     * @return void
     */
    public static function setTypes(string $type)
    {
        if ($type === 'moment') { //朋友圈
            self::$types = ['image', 'link', 'video'];
            self::$image = ["media_id" => ''];
            self::$link = ['title' => '', 'media_id' => '', 'url' => ''];
        } else {
            self::$types = ['image', 'link', 'miniprogram', 'video', 'file'];
            self::$image = ["media_id" => '', "pic_url" => ''];
            self::$link = ['title' => '', 'picurl' => '', 'desc' => '', 'url' => ''];
            self::$miniprogram = ['title' => '', 'pic_media_id' => '', 'appid' => '', 'page' => ''];

            self::$file = ['media_id' => ''];
        }
        self::$video = ['media_id' => ''];
    }

    /**
     * @param array $params 附件数组
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public static function formatMessage(array $params = []): array
    {
        $attachments = [];
        foreach ($params as $msgtype => $param) {
            switch ($msgtype) {
                case 'image':
                    $attachments[] = self::formatFields($param, self::$image, $msgtype);
                    break;
                case 'link':
                    $attachments[] = self::formatFields($param, self::$link, $msgtype);
                    break;
                case 'miniprogram':
                    $attachments[] = self::formatFields($param, self::$miniprogram, $msgtype);
                    break;
                case 'video':
                    $attachments[] = self::formatFields($param, self::$video, $msgtype);
                    break;
                case 'file':
                    $attachments[] = self::formatFields($param, self::$file, $msgtype);
                    break;
                default:
                    break;
            }
        }
        return $attachments;
    }

    /**
     * 格式化附件
     * @param string $msgtype 附件类型
     * @param array $data 附件内容
     * @param array $default 附件默认格式
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    public static function formatFields(array $data, array $default, string $msgtype): array
    {
        $params = array_merge($default, $data);
        foreach ($params as $key => $value) {
            if (in_array($key, self::$types, true) && empty($value) && empty($default[$key])) {
                throw new InvalidArgumentException(sprintf('Attribute "%s" can not be empty!', $key));
            }
            $params[$key] = empty($value) ? $default[$key] : $value;
        }
        return [
            'msgtype' => $msgtype,
            $msgtype => $params
        ];
    }

}
