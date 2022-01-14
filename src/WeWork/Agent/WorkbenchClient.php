<?php

namespace WorkWechatSdk\WeWork\Agent;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 企业微信应用工作台.
 */
class WorkbenchClient extends BaseClient
{
    /**
     * 设置工作台自定义展示
     * @param int $agentId
     * @param $attributes
     * @return array|object|ResponseInterface|string|Collection
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/92535
     */
    public function setWorkbenchTemplate(int $agentId, $attributes)
    {
        return $this->httpPostJson('cgi-bin/agent/set_workbench_template', array_merge(['agentid' => $agentId], $attributes));
    }

    /**
     * 获取应用在工作台展示的模版
     * @param int $agentId
     * @return array|object|ResponseInterface|string|Collection
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/92535
     */
    public function getWorkbenchTemplate(int $agentId)
    {
        $params = [
            'agentid' => $agentId,
        ];
        return $this->httpGet('cgi-bin/agent/get_workbench_template', $params);
    }

    /**
     * 设置应用在用户工作台展示的数据
     * @param int $agentId
     * @param $attributes
     * @return array|object|ResponseInterface|string|Collection
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/92535
     */
    public function setWorkbenchData(int $agentId, $attributes)
    {
        return $this->httpPostJson('cgi-bin/agent/set_workbench_data', array_merge(['agentid' => $agentId], $attributes));
    }
}
