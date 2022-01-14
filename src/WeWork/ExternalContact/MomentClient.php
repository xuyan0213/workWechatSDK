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
 * 客户朋友圈
 *
 */
class MomentClient extends BaseClient
{
    /**
     * 创建发表任务
     *
     * @see https://developer.work.weixin.qq.com/document/path/95094#%E5%88%9B%E5%BB%BA%E5%8F%91%E8%A1%A8%E4%BB%BB%E5%8A%A1
     *
     * @param array $userList 发表任务的执行者用户列表，最多支持10万个
     * @param array $departmentList 发表任务的执行者部门列表
     * @param array $tagList 可见到该朋友圈的客户标签列表
     * @param string $content 消息文本内容，不能与附件同时为空，最多支持传入2000个字符，若超出长度报错'invalid text size'
     * @param array $attachments 附件，不能与content同时为空，最多支持9个图片类型，或者1个视频，或者1个链接。类型只能三选一，若传了不同类型，报错'invalid attachments msgtype'
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException|InvalidConfigException|InvalidArgumentException
     */
    public function createTask(array $userList, array $departmentList, array $tagList, string $content, array $attachments)
    {
        Helpers::setTypes('moment');
        $param = [
            'visible_range' => [ //指定的发表范围
                'sender_list' => [
                    'user_list' => $userList,
                    'department_list' => $departmentList
                ],
                'external_contact_list' => [
                    'tag_list' => $tagList
                ]
            ],
            'text' => [
                'content' => $content
            ],
            'attachments' => Helpers::formatMessage($attachments)
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/add_moment_task', $param);
    }

    /**
     * 获取任务创建结果
     *
     * @see https://developer.work.weixin.qq.com/document/path/95094#%E8%8E%B7%E5%8F%96%E4%BB%BB%E5%8A%A1%E5%88%9B%E5%BB%BA%E7%BB%93%E6%9E%9C
     *
     * @param string $jobId 异步任务id，最大长度为64字节，由创建发表内容到客户朋友圈任务接口获取
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException|GuzzleException
     */
    public function getTask(string $jobId)
    {
        return $this->httpGet('cgi-bin/externalcontact/get_moment_task_result', ['jobid' => $jobId]);
    }


    /**
     * 获取企业全部的发表列表.
     *
     * @see https://developer.work.weixin.qq.com/document/path/93333#获取企业全部的发表列表
     *
     * @param string $startTime 必填    朋友圈记录开始时间。Unix时间戳
     * @param string $endTime 必填    朋友圈记录结束时间。Unix时间戳
     * @param string $creator 朋友圈创建人的userid
     * @param int $filterType 朋友圈类型。0：企业发表 1：个人发表 2：所有，包括个人创建以及企业创建，默认情况下为所有类型
     * @param string $cursor 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     * @param int $limit 返回的最大记录数，整型，最大值20，默认值20，超过最大值时取默认值
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException|InvalidConfigException
     */
    public function list(string $startTime, string $endTime, string $creator = '', int $filterType = 2, string $cursor = '', int $limit = 20)
    {
        $params = [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'creator' => $creator,
            'filter_type' => $filterType,
            'cursor' => $cursor,
            'limit' => $limit
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/get_moment_list', $params);
    }

    /**
     * 获取客户朋友圈企业发表的列表
     * (企业和第三方应用可通过该接口获取企业发表的朋友圈成员执行情况)
     * @see https://developer.work.weixin.qq.com/document/path/93333#获取客户朋友圈企业发表的列表
     *
     * @param string $momentId 朋友圈id,仅支持企业发表的朋友圈id
     * @param string $cursor 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     * @param int $limit 返回的最大记录数，整型，最大值1000，默认值500，超过最大值时取默认值
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function getTasks(string $momentId, string $cursor = '', int $limit = 500)
    {
        $params = [
            'moment_id' => $momentId,
            'cursor' => $cursor,
            'limit' => $limit
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/get_moment_task', $params);
    }

    /**
     * 获取客户朋友圈发表时选择的可见范围.
     *
     * @see https://developer.work.weixin.qq.com/document/path/93333#获取客户朋友圈发表时选择的可见范围
     *
     * @param string $momentId 	朋友圈id
     * @param string $userId 	企业发表成员userid，如果是企业创建的朋友圈，可以通过获取客户朋友圈企业发表的列表获取已发表成员userid，如果是个人创建的朋友圈，创建人userid就是企业发表成员userid
     * @param string $cursor	用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     * @param int $limit 	    返回的最大记录数，整型，最大值1000，默认值500，超过最大值时取默认值
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function getCustomers(string $momentId, string $userId, string $cursor, int $limit)
    {
        $params = [
            'moment_id' => $momentId,
            'userid' => $userId,
            'cursor' => $cursor,
            'limit' => $limit
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/get_moment_customer_list', $params);
    }

    /**
     * 获取客户朋友圈发表后的可见客户列表.
     *
     * @see https://developer.work.weixin.qq.com/document/path/93333#获取客户朋友圈发表后的可见客户列表
     *
     * @param string $momentId 朋友圈id
     * @param string $userId 	企业发表成员userid，如果是企业创建的朋友圈，可以通过获取客户朋友圈企业发表的列表获取已发表成员userid，如果是个人创建的朋友圈，创建人userid就是企业发表成员userid
     * @param string $cursor 	用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     * @param int $limit 	返回的最大记录数，整型，最大值5000，默认值3000，超过最大值时取默认值
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function getSendResult(string $momentId, string $userId, string $cursor, int $limit)
    {
        $params = [
            'moment_id' => $momentId,
            'userid' => $userId,
            'cursor' => $cursor,
            'limit' => $limit
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/get_moment_send_result', $params);
    }

    /**
     * 获取客户朋友圈的互动数据.
     *
     * @see https://developer.work.weixin.qq.com/document/path/93333#获取客户朋友圈的互动数据
     *
     * @param string $momentId 	朋友圈id
     * @param string $userId 企业发表成员userid，如果是企业创建的朋友圈，可以通过获取客户朋友圈企业发表的列表获取已发表成员userid，如果是个人创建的朋友圈，创建人userid就是企业发表成员userid
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function getComments(string $momentId, string $userId)
    {
        $params = [
            'moment_id' => $momentId,
            'userid' => $userId
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/get_moment_comments', $params);
    }
}
