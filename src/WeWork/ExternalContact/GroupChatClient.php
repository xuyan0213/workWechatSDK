<?php


namespace WorkWechatSdk\WeWork\ExternalContact;

use WorkWechatSdk\Kernel\BaseClient;
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
     * @param string $chatId 客户群ID
     * @param int $needName 是否需要返回群成员的名字group_chat.member_list.name。0-不返回；1-返回。默认不返回
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
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

     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/94822
     */
    public function opengidToChatid(string $opengid)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/get', compact('opengid'));
    }

    /**
     * 配置客户群进群方式
     * @see https://developer.work.weixin.qq.com/document/path/92229#%E9%85%8D%E7%BD%AE%E5%AE%A2%E6%88%B7%E7%BE%A4%E8%BF%9B%E7%BE%A4%E6%96%B9%E5%BC%8F
     * @param int $scene 必填 场景。1:群的小程序插件, 2:群的二维码插件
     * @param array $chatIdList 必填 使用该配置的客户群ID列表，支持5个。见客户群ID获取方法
     * @param array $fields 非必填项,详情参考文档
     * @return array|Collection|object|ResponseInterface|string

     * @throws InvalidConfigException
     */
    public function addJoinWay(int $scene, array $chatIdList, array $fields)
    {
        $tmp = [
            'scene' => $scene,
            'chat_id_list' => $chatIdList,
        ];
        $params = $fields ? array_merge($tmp, $fields) : $tmp;
        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/add_join_way', $params);
    }

    /**
     * 获取客户群进群方式配置
     *
     * @see https://developer.work.weixin.qq.com/document/path/92229#获取客户群进群方式配置
     * @param string $configId	联系方式的配置id
     * @return array|object|ResponseInterface|string|Collection

     * @throws InvalidConfigException
     */
    public function getJoinWay(string $configId)
    {
        $params  = [
            'config_id' => $configId
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/get_join_way', $params);
    }

    /**
     * 更新客户群进群方式配置
     *
     * @see https://developer.work.weixin.qq.com/document/path/92229#更新客户群进群方式配置
     * @param string $configId
     * @param int $scene 必填 场景。1:群的小程序插件, 2:群的二维码插件
     * @param array $chatIdList 必填 使用该配置的客户群ID列表，支持5个。见客户群ID获取方法
     * @param array $fields 非必填项,详情参考文档
     * @return array|object|ResponseInterface|string|Collection

     * @throws InvalidConfigException
     */
    public function updateJoinWay(string $configId, int $scene, array $chatIdList, array $fields)
    {
        $tmp = [
            'config_id' => $configId,
            'scene' => $scene,
            'chat_id_list' => $chatIdList,
        ];
        $params = $fields ? array_merge($tmp, $fields) : $tmp;
        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/update_join_way', $params);
    }

    /**
     * 删除客户群进群方式配置
     *
     * @see https://developer.work.weixin.qq.com/document/path/92229#删除客户群进群方式配置
     * @param string $configId 联系方式的配置id
     * @return array|object|ResponseInterface|string|Collection

     * @throws InvalidConfigException
     */
    public function delJoinWay(string $configId)
    {
        $params  = [
            'config_id' => $configId
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/del_join_way', $params);
    }
}
