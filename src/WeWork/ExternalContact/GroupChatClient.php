<?php


namespace WorkWechatSdk\WeWork\ExternalContact;
;

use WorkWechatSdk\Kernel\BaseClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 客户群
 *
 */
class GroupChatClient extends BaseClient
{
    /**
     * 获取客户群列表.
     *
     * @see https://developer.work.weixin.qq.com/document/path/92120
     *
     * @param int $statusFilter 客户群跟进状态过滤。0:所有列表(即不过滤),1:离职待继承,2:离职继承中,3:离职继承完成
     * @param array $useridList 用户ID列表。最多100个(群主过滤) 如果不填，表示获取应用可见范围内全部群主的数据（但是不建议这么用，如果可见范围人数超过1000人，为了防止数据包过大，会报错 81017）
     * @param string $cursor 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用不填
     * @param int $limit 分页，预期请求的数据量，取值范围 1 ~ 1000
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException|InvalidConfigException
     */

    public function getGroupChats(int $statusFilter = 0, array $useridList = [], string $cursor = '', int $limit = 1000)
    {
        $params = [
            'status_filter' => $statusFilter,
            'owner_filter' => [
                'userid_list' => $useridList
            ],
            'cursor' => $cursor,
            'limit' => $limit
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/list', $params);
    }

    /**
     * 获取客户群详情
     *
     * @see https://developer.work.weixin.qq.com/document/path/92122
     *
     * @param string $chatId    客户群ID
     * @param int $needName     是否需要返回群成员的名字group_chat.member_list.name。0-不返回；1-返回。默认不返回
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     */

    public function getGroupChat(string $chatId, int $needName = 0)
    {
        $params = [
            'chat_id' => $chatId,
            'need_name' => $needName,
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/get', $params);
    }

    /**
     * 客户群opengid转换
     *
     * @param string $opengid 小程序在微信获取到的群ID，参见wx.getGroupEnterInfo
     * @return array|object|ResponseInterface|string|Collection
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/94822
     */
    public function opengidToChatid(string $opengid)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/get', compact('opengid'));
    }
}
