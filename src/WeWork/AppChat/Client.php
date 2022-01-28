<?php


namespace WorkWechatSdk\WeWork\AppChat;

use WorkWechatSdk\Kernel\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;

/**
 * 群聊会话
 *
 */
class Client extends BaseClient
{

    /**
     * 创建群聊会话
     *
     * @param array $data
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/90245
     */
    public function create(array $data)
    {
        return $this->httpPostJson('cgi-bin/appchat/create', $data);
    }

    /**
     * 修改群聊会话
     * @param string $chatId 群聊ID
     * @param array $data 数据结构
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/90246
     */
    public function update(string $chatId, array $data)
    {
        return $this->httpPostJson('cgi-bin/appchat/update', array_merge(['chatid' => $chatId], $data));
    }

    /**
     * 获取群聊会话
     *
     * @param string $chatId 群聊ID
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     *
     * @see https://developer.work.weixin.qq.com/document/path/90247
     */
    public function get(string $chatId)
    {
        return $this->httpGet('cgi-bin/appchat/get', ['chatid' => $chatId]);
    }

    /**
     * 应用推送消息
     *
     * @param array $message 请求包体
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/90248
     */
    public function send(array $message)
    {
        return $this->httpPostJson('cgi-bin/appchat/send', $message);
    }
}
