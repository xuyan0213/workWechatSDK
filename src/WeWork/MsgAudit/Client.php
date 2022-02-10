<?php


namespace WorkWechatSdk\WeWork\MsgAudit;

use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;


/**
 * 会话内容存档
 */
class Client extends BaseClient
{
    /**
     * 获取会话内容存档开启成员列表
     * @see https://developer.work.weixin.qq.com/document/path/91614
     * @param string|null $type
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     */
    public function getPermitUsers(string $type = null)
    {
        return $this->httpPostJson('cgi-bin/msgaudit/get_permit_user_list', (empty($type) ? [] : ['type' => $type]));
    }

    /**
     * 获取会话同意情况(单聊)
     * @see https://developer.work.weixin.qq.com/document/path/91782
     * @param array $info 数组，格式: [[userid, exteranalopenid], [userid, exteranalopenid]]
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * 
     */
    public function getSingleAgreeStatus(array $info)
    {
        $params = [
            'info' => $info
        ];

        return $this->httpPostJson('cgi-bin/msgaudit/check_single_agree', $params);
    }

    /**
     * 获取会话同意情况(群聊)
     * @see https://developer.work.weixin.qq.com/document/path/91782
     * @param  string  $roomId
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * 
     */
    public function getRoomAgreeStatus(string $roomId)
    {
        $params = [
            'roomid' => $roomId
        ];

        return $this->httpPostJson('cgi-bin/msgaudit/check_room_agree', $params);
    }

    /**
     * 获取会话内容存档内部群信息
     * @see https://developer.work.weixin.qq.com/document/path/92951
     * @param  string  $roomId
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * 
     */
    public function getRoom(string $roomId)
    {
        $params = [
            'roomid' => $roomId
        ];

        return $this->httpPostJson('cgi-bin/msgaudit/groupchat/get', $params);
    }
}
