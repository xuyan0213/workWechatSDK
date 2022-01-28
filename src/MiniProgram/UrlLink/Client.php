<?php

namespace WorkWechatSdk\MiniProgram\UrlLink;

use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Url Scheme
 *
 * Class Client
 * @package EasyWeChat\MiniProgram\UrlLink
 */
class Client extends BaseClient
{
    /**
     * 获取小程序 URL Link
     *
     * @param  array  $param
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function generate(array $param = [])
    {
        return $this->httpPostJson('wxa/generate_urllink', $param);
    }
}
