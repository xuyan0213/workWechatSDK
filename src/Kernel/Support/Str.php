<?php

namespace WorkWechatSdk\Kernel\Support;

use WorkWechatSdk\Kernel\Exceptions\RuntimeException;
use Exception;

/**
 * Class Str.
 */
class Str
{
    /**
     * 蛇形单词缓存
     *
     * @var array
     */
    protected static $snakeCache = [];

    /**
     * 驼峰单词缓存
     *
     * @var array
     */
    protected static $camelCache = [];

    /**
     * 大小写单词缓存
     *
     * @var array
     */
    protected static $studlyCache = [];

    /**
     * 将一个值转换为驼峰写法。
     *
     * @param string $value
     *
     * @return string
     */
    public static function camel(string $value): string
    {
        if (isset(static::$camelCache[$value])) {
            return static::$camelCache[$value];
        }

        return static::$camelCache[$value] = lcfirst(static::studly($value));
    }

    /**
     * 生成一个更“随机”的字母数字字符串。
     *
     * @param int $length
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public static function random(int $length = 16): string
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = static::randomBytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    /**
     * 生成一个更真实的“随机”字节。
     *
     * @param int $length
     *
     * @return string
     *
     * @throws RuntimeException
     *
     * @codeCoverageIgnore
     *
     * @throws Exception
     */
    public static function randomBytes(int $length = 16): string
    {
        if (function_exists('random_bytes')) {
            $bytes = random_bytes($length);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length, $strong);
            if (false === $bytes || false === $strong) {
                throw new RuntimeException('Unable to generate random string.');
            }
        } else {
            throw new RuntimeException('OpenSSL extension is required for PHP 5 users.');
        }

        return $bytes;
    }

    /**
     * 生成一个“随机”字母数字字符串。
     *
     * 对于密码学等来说是不够的。
     *
     * @param int $length
     *
     * @return string
     */
    public static function quickRandom(int $length = 16): string
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * 将给定的字符串转换为大写。
     *
     * @param string $value
     *
     * @return string
     */
    public static function upper(string $value): string
    {
        return mb_strtoupper($value);
    }

    /**
     * 将给定的字符串转换为标题大小写。
     *
     * @param string $value
     *
     * @return string
     */
    public static function title(string $value): string
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * 将字符串转换为蛇型字符串。
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public static function snake(string $value, string $delimiter = '_'): string
    {
        $key = $value.$delimiter;

        if (isset(static::$snakeCache[$key])) {
            return static::$snakeCache[$key];
        }

        if (!ctype_lower($value)) {
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/', '$1'.$delimiter, $value));
        }

        return static::$snakeCache[$key] = trim($value, '_');
    }

    /**
     * 将值转换为大写格式.
     *
     * @param string $value
     *
     * @return string
     */
    public static function studly(string $value): string
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }
}