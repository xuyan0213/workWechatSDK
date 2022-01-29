<?php


namespace WorkWechatSdk\WeWork\Message;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Messages\Message;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 消息推送
 *
 */
class Client extends BaseClient
{
    /**
     * @param string|Message $message
     *
     * @return Messenger
     *
     * @throws InvalidArgumentException
     */
    public function message($message): Messenger
    {
        return (new Messenger($this))->message($message);
    }

    /**
     * 推送消息
     * @param array $message
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function send(array $message)
    {
        return $this->httpPostJson('cgi-bin/message/send', $message);
    }

    /**
     * 更新任务卡片消息状态
     *
     * @see https://open.work.weixin.qq.com/api/doc/90000/90135/91579
     *
     * @param array $userids
     * @param int $agentId
     * @param string $taskId
     * @param string $replaceName
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     */
    public function updateTaskCard(array $userids, int $agentId, string $taskId, string $replaceName = '已收到')
    {
        $params = [
            'userids' => $userids,
            'agentid' => $agentId,
            'task_id' => $taskId,
            'replace_name' => $replaceName
        ];

        return $this->httpPostJson('cgi-bin/message/update_taskcard', $params);
    }
}
