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

use WorkWechatSdk\Kernel\Exceptions\RuntimeException;
use WorkWechatSdk\Kernel\Support\AES;
use WorkWechatSdk\Kernel\Support\XML;
use Throwable;
use function WorkWechatSdk\Kernel\Support\strRandom;

/**
 * Class Encryptor.
 *
 */
class Encryptor
{
    const ERROR_INVALID_SIGNATURE = -40001; // 签名验证错误
    const ERROR_PARSE_XML = -40002; // 	xml/json解析失败
    const ERROR_CALC_SIGNATURE = -40003; // sha加密生成签名失败
    const ERROR_INVALID_AES_KEY = -40004; // AESKey 非法
    const ERROR_RECEIVE_ID = -40005; // ReceiveId 校验错误
    const ERROR_ENCRYPT_AES = -40006; // AES 加密失败
    const ERROR_DECRYPT_AES = -40007; // AES 解密失败
    const ILLEGAL_BUFFER = -40008; // 解密后得到的buffer非法
    const ERROR_BASE64_ENCODE = -40009; // base64加密失败
    const ERROR_BASE64_DECODE = -40010; // base64解密失败
    const ERROR_XML_BUILD = -40011; // 生成xml/json失败

    /**
     * App id.
     *
     * @var string
     */
    protected $appId;

    /**
     * App token.
     *
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $aesKey;

    /**
     * Block size.
     *
     * @var int
     */
    protected $blockSize = 32;

    /**
     * Constructor.
     *
     * @param string      $appId
     * @param string|null $token
     * @param string|null $aesKey
     */
    public function __construct(string $appId, string $token = null, string $aesKey = null)
    {
        $this->appId = $appId;
        $this->token = $token;
        $this->aesKey = base64_decode($aesKey.'=', true);
    }

    /**
     * Get the app token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Encrypt the message and return XML.
     *
     * @param string $xml
     * @param string|null $nonce
     * @param int|null $timestamp
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public function encrypt(string $xml, string $nonce = null, int $timestamp = null): string
    {
        try {
            $xml = $this->pkcs7Pad(strRandom(16).pack('N', strlen($xml)).$xml.$this->appId, $this->blockSize);

            $encrypted = base64_encode(AES::encrypt(
                $xml,
                $this->aesKey,
                substr($this->aesKey, 0, 16),
                OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING
            ));
            // @codeCoverageIgnoreStart
        } catch (Throwable $e) {
            throw new RuntimeException($e->getMessage(), self::ERROR_ENCRYPT_AES);
        }
        // @codeCoverageIgnoreEnd

        !is_null($nonce) || $nonce = substr($this->appId, 0, 10);
        !is_null($timestamp) || $timestamp = time();

        $response = [
            'Encrypt' => $encrypted,
            'MsgSignature' => $this->signature($this->token, $timestamp, $nonce, $encrypted),
            'TimeStamp' => $timestamp,
            'Nonce' => $nonce,
        ];

        //生成响应xml
        return XML::build($response);
    }

    /**
     * Decrypt message.
     *
     * @param string $content
     * @param string $msgSignature
     * @param string $nonce
     * @param string $timestamp
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public function decrypt($content, $msgSignature, $nonce, $timestamp): string
    {
        $signature = $this->signature($this->token, $timestamp, $nonce, $content);

        if ($signature !== $msgSignature) {
            throw new RuntimeException('Invalid Signature.', self::ERROR_INVALID_SIGNATURE);
        }

        $decrypted = AES::decrypt(
            base64_decode($content, true),
            $this->aesKey,
            substr($this->aesKey, 0, 16),
            OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING
        );
        $result = $this->pkcs7Unpad($decrypted);
        $content = substr($result, 16, strlen($result));
        $contentLen = unpack('N', substr($content, 0, 4))[1];

        if (trim(substr($content, $contentLen + 4)) !== $this->appId) {
            throw new RuntimeException('Invalid appId.', self::ERROR_RECEIVE_ID);
        }

        return substr($content, 4, $contentLen);
    }

    /**
     * Get SHA1.
     *
     * @return string
     */
    public function signature(): string
    {
        $array = func_get_args();
        sort($array, SORT_STRING);

        return sha1(implode($array));
    }

    /**
     * PKCS#7 pad.
     *
     * @param string $text
     * @param int    $blockSize
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public function pkcs7Pad(string $text, int $blockSize): string
    {
        if ($blockSize > 256) {
            throw new RuntimeException('$blockSize may not be more than 256');
        }
        $padding = $blockSize - (strlen($text) % $blockSize);
        $pattern = chr($padding);

        return $text.str_repeat($pattern, $padding);
    }

    /**
     * PKCS#7 unpad.
     *
     * @param string $text
     *
     * @return string
     */
    public function pkcs7Unpad(string $text): string
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > $this->blockSize) {
            $pad = 0;
        }

        return substr($text, 0, (strlen($text) - $pad));
    }
}
