<?php


namespace WorkWechatSdk\Kernel\Support;


use Closure;

/**
 * 生成签名
 *
 * @param array  $attributes
 * @param string $key
 * @param string $encryptMethod
 *
 * @return string
 */
function generateSign(array $attributes, string $key, string $encryptMethod = 'md5'): string
{
    ksort($attributes);

    $attributes['key'] = $key;

    return strtoupper(call_user_func_array($encryptMethod, [urldecode(http_build_query($attributes))]));
}

/**
 * 获取加密方法
 * @param string $signType
 * @param string $secretKey
 *
 * @return Closure|string
 */
function getEncryptMethod(string $signType, string $secretKey = '')
{
    if ('HMAC-SHA256' === $signType) {
        return function ($str) use ($secretKey) {
            return hash_hmac('sha256', $str, $secretKey);
        };
    }

    return 'md5';
}

/**
 * 获取客户端IP地址
 *
 * @return string
 */
function getClientIp(): string
{
    if (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        // for php-cli(phpunit etc.)
        $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
    }

    return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
}

/**
 * 获取服务端IP地址
 *
 * @return string
 */
function getServerIp(): string
{
    if (!empty($_SERVER['SERVER_ADDR'])) {
        $ip = $_SERVER['SERVER_ADDR'];
    } elseif (!empty($_SERVER['SERVER_NAME'])) {
        $ip = gethostbyname($_SERVER['SERVER_NAME']);
    } else {
        // for php-cli(phpunit etc.)
        $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
    }

    return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
}

/**
 * 返回当前URL地址.
 *
 * @return string
 */
function currentUrl(): string
{
    $protocol = 'http://';

    if ((!empty($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS']) || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'http') === 'https') {
        $protocol = 'https://';
    }

    return $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

/**
 * 返回指定长度的字符串.
 *
 * @param string $length
 *
 * @return string
 */
function strRandom(string $length): string
{
    return Str::random($length);
}

/**
 * 使用公钥加密数据
 * @param string $content
 * @param string $publicKey
 *
 * @return string
 */
function rsaPublicEncrypt(string $content, string $publicKey): string
{
    $encrypted = '';
    openssl_public_encrypt($content, $encrypted, openssl_pkey_get_public($publicKey), OPENSSL_PKCS1_OAEP_PADDING);

    return base64_encode($encrypted);
}