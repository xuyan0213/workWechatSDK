<?php


namespace WorkWechatSdk\WeWork\MiniProgram\Auth;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSDK\Kernel\BaseClient;
use WorkWechatSDK\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSDK\Kernel\Support\Collection;

/**
 * 小程序-临时登录凭证校验接口
 */
class Client extends BaseClient
{
    /**
     * Get session info by code.
     *
     * @param string $code
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function session(string $code)
    {
        $params = [
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];

        return $this->httpGet('cgi-bin/miniprogram/jscode2session', $params);
    }
}
