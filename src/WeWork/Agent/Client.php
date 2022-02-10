<?php


namespace WorkWechatSdk\WeWork\Agent;

use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 应用管理
 *
 */
class Client extends BaseClient
{
    /**
     * 获取指定的应用详情
     *
     * @see https://developer.work.weixin.qq.com/document/path/90227
     * @param int $agentId
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws InvalidConfigException
     */
    public function get(int $agentId)
    {
        $params = [
            'agentid' => $agentId,
        ];

        return $this->httpGet('cgi-bin/agent/get', $params);
    }

    /**
     * 设置应用
     *
     * @see https://developer.work.weixin.qq.com/document/path/90228
     * @param int   $agentId
     * @param array $attributes
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     */
    public function set(int $agentId, array $attributes)
    {
        return $this->httpPostJson('cgi-bin/agent/set', array_merge(['agentid' => $agentId], $attributes));
    }

    /**
     * 创建自定义菜单
     * @param int $agentId
     * @param array $attributes
     * @return array|Collection|object|ResponseInterface|string
     
     * @throws InvalidConfigException
     */
    public function createMenu(int $agentId,array $attributes)
    {
        return $this->httpPostJson('cgi-bin/menu/create', array_merge(['agentid' => $agentId], $attributes));
    }

    /**
     * 获取菜单
     * @param int $agentId
     * @return array|Collection|object|ResponseInterface|string
     
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/90232
     */
    public function getMenu(int $agentId)
    {
        $params = [
            'agentid' => $agentId,
        ];
        return $this->httpGet('cgi-bin/menu/get', $params);
    }


    /**
     * 删除菜单
     * @param int $agentId
     * @return array|Collection|object|ResponseInterface|string
     
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/90233
     */
    public function deleteMenu(int $agentId)
    {
        $params = [
            'agentid' => $agentId,
        ];
        return $this->httpGet('cgi-bin/menu/delete', $params);
    }

    /**
     * 获取应用列表
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException
     *
     * @deprecated 企微已废弃该接口,请勿使用
     */
    public function list()
    {
        return $this->httpGet('cgi-bin/agent/list');
    }
}
