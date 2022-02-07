<?php


namespace WorkWechatSdk\WeWork\ExternalContact;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Helpers;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 客户联系-消息推送
 *
 */
class MessageClient extends BaseClient
{
    /**
     * 添加企业群发消息模板
     *
     * @see https://developer.work.weixin.qq.com/document/path/92135
     *
     * @param string $chatType 群发任务的类型，默认为single，表示发送给客户，group表示发送给客户群
     * @param array $externalUserid 客户的外部联系人id列表，仅在chat_type为single时有效，不可与sender同时为空，最多可传入1万个客户
     * @param string $sender 发送企业群发消息的成员userid，当类型为发送给客户群时必填
     * @param string $content 消息文本内容，最多4000个字节
     * @param array $attachments 附件，最多支持添加9个附件
     *
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    public function addMsgTemplate(string $chatType, array $externalUserid, string $sender, string $content, array $attachments)
    {
        Helpers::setTypes('welcome'); //设置格式化数组为欢迎语
        $params = [
            'chat_type' => $chatType,
            'external_userid' => $externalUserid,
            'sender' => $sender,
            'text' => [
                'content' => $content
            ],
            'attachments' => Helpers::formatMessage($attachments)
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/add_msg_template', $params);
    }

    /**
     * 获取企业群发消息发送结果.
     * @param string $msgId 群发消息的id，通过创建企业群发接口返回
     * @param int $limit 返回的最大记录数，整型，最大值10000，默认值10000
     * @param string $cursor 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     * @deprecated 企微接口不再维护
     * @see https://developer.work.weixin.qq.com/document/16251
     */
    public function get(string $msgId, int $limit = 10000, string $cursor = '')
    {
        return $this->httpPostJson('cgi-bin/externalcontact/get_group_msg_result', [
            'msgid' => $msgId,
            'limit' => $limit,
            'cursor' => $cursor
        ]);
    }

    /**
     * 获取群发记录列表.
     *
     * @see https://developer.work.weixin.qq.com/document/path/93338
     *
     * @param string $chatType 群发任务的类型，默认为single，表示发送给客户，group表示发送给客户群
     * @param int $startTime 群发任务记录开始时间
     * @param int $endTime 群发任务记录结束时间
     * @param string|null $creator 群发任务创建人企业账号id
     * @param int|null $filterType 创建人类型。0：企业发表 1：个人发表 2：所有，包括个人创建以及企业创建，默认情况下为所有类型
     * @param int|null $limit 返回的最大记录数，整型，最大值100，默认值50，超过最大值时取默认值
     * @param string|null $cursor 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getGroupmsgListV2(string $chatType, int $startTime, int $endTime, string $creator = null, int $filterType = null, int $limit = null, string $cursor = null)
    {
        $data = [
            'chat_type' => $chatType,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'creator' => $creator,
            'filter_type' => $filterType,
            'limit' => $limit,
            'cursor' => $cursor,
        ];
        $writableData = array_filter($data, function (string $key) use ($data) {
            return !is_null($data[$key]);
        }, ARRAY_FILTER_USE_KEY);
        return $this->httpPostJson('cgi-bin/externalcontact/get_groupmsg_list_v2', $writableData);
    }

    /**
     * 获取群发成员发送任务列表.
     *
     * @see https://developer.work.weixin.qq.com/document/path/93338#%E8%8E%B7%E5%8F%96%E7%BE%A4%E5%8F%91%E6%88%90%E5%91%98%E5%8F%91%E9%80%81%E4%BB%BB%E5%8A%A1%E5%88%97%E8%A1%A8
     *
     * @param string $msgId 群发消息的id，通过获取群发记录列表接口返回
     * @param int|null $limit 返回的最大记录数，整型，最大值1000，默认值500，超过最大值时取默认值
     * @param string|null $cursor 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function getGroupmsgTask(string $msgId, int $limit = null, string $cursor = null)
    {
        $data = [
            'msgid' => $msgId,
            'limit' => $limit,
            'cursor' => $cursor,
        ];
        $writableData = array_filter($data, function (string $key) use ($data) {
            return !is_null($data[$key]);
        }, ARRAY_FILTER_USE_KEY);
        return $this->httpPostJson('cgi-bin/externalcontact/get_groupmsg_task', $writableData);
    }

    /**
     * 获取企业群发成员执行结果.
     *
     * @see https://developer.work.weixin.qq.com/document/path/93338#%E8%8E%B7%E5%8F%96%E4%BC%81%E4%B8%9A%E7%BE%A4%E5%8F%91%E6%88%90%E5%91%98%E6%89%A7%E8%A1%8C%E7%BB%93%E6%9E%9C
     *
     * @param string $msgId 群发消息的id，通过获取群发记录列表接口返回
     * @param string $userid 发送成员userid，通过获取群发成员发送任务列表接口返回
     * @param int|null $limit 返回的最大记录数，整型，最大值1000，默认值500，超过最大值时取默认值
     * @param string|null $cursor 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getGroupmsgSendResult(string $msgId, string $userid, int $limit = null, string $cursor = null)
    {
        $data = [
            'msgid' => $msgId,
            'userid' => $userid,
            'limit' => $limit,
            'cursor' => $cursor,
        ];
        $writableData = array_filter($data, function (string $key) use ($data) {
            return !is_null($data[$key]);
        }, ARRAY_FILTER_USE_KEY);
        return $this->httpPostJson('cgi-bin/externalcontact/get_groupmsg_send_result', $writableData);
    }

    /**
     * 发送新客户欢迎语.
     *
     * @see https://developer.work.weixin.qq.com/document/path/92137
     *
     * @param string $welcomeCode
     * @param string $content
     * @param array $attachments
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    public function sendWelcome(string $welcomeCode, string $content = '', array $attachments = [])
    {
        Helpers::setTypes('welcome'); //设置格式化数组为欢迎语
        $params = [
            'welcome_code' => $welcomeCode,
            'text' => [
                'content' => $content
            ],
            'attachments' => Helpers::formatMessage($attachments)
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/send_welcome_msg', $params);
    }

    /**
     * 添加入群欢迎语素材
     *
     * @param $msgTemplate array 欢迎语模板
     * @see https://developer.work.weixin.qq.com/document/path/92366#%E6%B7%BB%E5%8A%A0%E5%85%A5%E7%BE%A4%E6%AC%A2%E8%BF%8E%E8%AF%AD%E7%B4%A0%E6%9D%90
     *
     * @throws InvalidConfigException|GuzzleException
     * @return array|Collection|object|ResponseInterface|string
     */
    public function addGroupWelcomeTemplate(array $msgTemplate)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/group_welcome_template/add', $msgTemplate);
    }

    /**
     * 编辑入群欢迎语素材.
     *
     * @see https://developer.work.weixin.qq.com/document/path/92366#%E7%BC%96%E8%BE%91%E5%85%A5%E7%BE%A4%E6%AC%A2%E8%BF%8E%E8%AF%AD%E7%B4%A0%E6%9D%90
     *
     * @param $templateId string    欢迎语素材id
     * @param $msgTemplate array    欢迎语模板
     * @throws InvalidConfigException
     * @throws GuzzleException
     * @return array|Collection|object|ResponseInterface|string
     */
    public function updateGroupWelcomeTemplate(string $templateId, array $msgTemplate)
    {
        $params = array_merge([
            'template_id' => $templateId,
        ], $msgTemplate);
        return $this->httpPostJson('cgi-bin/externalcontact/group_welcome_template/edit', $params);
    }

    /**
     * 获取入群欢迎语素材
     *
     * @see https://developer.work.weixin.qq.com/document/path/92366#获取入群欢迎语素材
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     * @return array|Collection|object|ResponseInterface|string
     */
    public function getGroupWelcomeTemplate(string $templateId)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/group_welcome_template/get', [
            'template_id' => $templateId,
        ]);
    }

    /**
     * 删除入群欢迎语素材.
     *
     * @see https://developer.work.weixin.qq.com/document/path/92366#%E5%88%A0%E9%99%A4%E5%85%A5%E7%BE%A4%E6%AC%A2%E8%BF%8E%E8%AF%AD%E7%B4%A0%E6%9D%90
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     * @return array|Collection|object|ResponseInterface|string
     */
    public function deleteGroupWelcomeTemplate(string $templateId)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/group_welcome_template/del', [
            'template_id' => $templateId,
        ]);
    }
}
