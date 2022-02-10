<?php


namespace WorkWechatSdk\WeWork\CorpGroup;

use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 企业互联
 *
 */
class Client extends BaseClient
{
    /**
     * 获取应用共享信息.
     *
     * @param int $agentId
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException

     *
     * @see https://developer.work.weixin.qq.com/document/path/93403
     */
    public function getAppShareInfo(int $agentId)
    {
        $params = [
            'agentid' => $agentId
        ];

        return $this->httpPostJson('cgi-bin/corpgroup/corp/list_app_share_info', $params);
    }

    /**
     * 获取下级企业的access_token.
     *
     * @param string $corpId
     * @param int $agentId
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException

     *
     * @see https://developer.work.weixin.qq.com/document/path/93359
     */
    public function getToken(string $corpId, int $agentId)
    {
        $params = [
            'corpid' => $corpId,
            'agentid' => $agentId
        ];

        return $this->httpPostJson('cgi-bin/corpgroup/corp/gettoken', $params);
    }

    /**
     * 获取下级企业的小程序session.
     *
     * @param string $userId
     * @param string $sessionKey
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException

     *
     * @see https://developer.work.weixin.qq.com/document/path/93355
     */
    public function getMiniProgramTransferSession(string $userId, string $sessionKey)
    {
        $params = [
            'userid' => $userId,
            'session_key' => $sessionKey
        ];

        return $this->httpPostJson('cgi-bin/miniprogram/transfer_session', $params);
    }
}
