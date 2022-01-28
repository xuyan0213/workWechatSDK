<?php


namespace WorkWechatSdk\WeWork\ExternalContact;

use WorkWechatSdk\Kernel\BaseClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 在职/离职继承
 *
 */
class TransferCustomerClient extends BaseClient
{
    /**
     * 获取离职成员的客户列表.
     *
     * @param int $pageId      分页查询，要查询页号，从0开始
     * @param int $pageSize    每次返回的最大记录数，默认为1000，最大值为1000
     * @param string $cursor   分页查询游标，字符串类型，适用于数据量较大的情况，如果使用该参数则无需填写page_id，该参数由上一次调用返回
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92124
     */
    public function getUnassigned(int $pageId = 0, int $pageSize = 1000, string $cursor = '')
    {
        $params = [
            'page_id' => $pageId,
            'page_size' => $pageSize,
            'cursor' => $cursor,
        ];
        $writableParams = array_filter($params, function (string $key) use ($params) {
            return !is_null($params[$key]);
        }, ARRAY_FILTER_USE_KEY);
        return $this->httpPostJson('cgi-bin/externalcontact/get_unassigned_list', $writableParams);
    }

    /**
     * 分配离职成员的客户.
     *
     * @see https://developer.work.weixin.qq.com/document/path/94081
     *
     * @param array $externalUserId     客户的external_userid列表，最多一次转移100个客户
     * @param string $handoverUserId    原跟进成员的userid
     * @param string $takeoverUserId    接替成员的userid
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function resignedTransferCustomer(array $externalUserId, string $handoverUserId, string $takeoverUserId)
    {
        $params = [
            'external_userid' => $externalUserId,
            'handover_userid' => $handoverUserId,
            'takeover_userid' => $takeoverUserId,
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/resigned/transfer_customer', $params);
    }

    /**
     * 分配离职成员的客户群
     *
     * @see https://developer.work.weixin.qq.com/document/path/92127
     * @param array $chatIds 	需要转群主的客户群ID列表。取值范围： 1 ~ 100
     * @param string $newOwner	新群主ID
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException|GuzzleException
     */
    public function transferGroupChat(array $chatIds, string $newOwner)
    {
        $params = [
            'chat_id_list' => $chatIds,
            'new_owner' => $newOwner
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/transfer', $params);
    }

    /**
     * 离职继承查询客户接替状态
     *
     * @see https://developer.work.weixin.qq.com/document/path/94082
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @param string $handoverUserId 原添加成员的userid
     * @param string $takeoverUserId 接替成员的userid
     * @param string $cursor    分页查询的cursor，每个分页返回的数据不会超过1000条；不填或为空表示获取第一个分页
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function resignedTransferResult(string $handoverUserId, string $takeoverUserId, string $cursor = '')
    {
        $params = [
            'handover_userid' => $handoverUserId,
            'takeover_userid' => $takeoverUserId,
            'cursor' => $cursor,
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/resigned/transfer_result', $params);
    }

    /**
     * 在职继承查询客户接替状态
     *
     * @see https://developer.work.weixin.qq.com/document/path/94088
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @param string $handoverUserId 原添加成员的userid
     * @param string $takeoverUserId 接替成员的userid
     * @param string $cursor    分页查询的cursor，每个分页返回的数据不会超过1000条；不填或为空表示获取第一个分页
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function transferResult(string $handoverUserId, string $takeoverUserId, string $cursor = '')
    {
        $params = [
            'handover_userid' => $handoverUserId,
            'takeover_userid' => $takeoverUserId,
            'cursor' => $cursor,
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/transfer_result', $params);
    }

    /**
     * 分配在职成员的客户
     *
     * @param array $externalUserId             客户的external_userid列表，每次最多分配100个客户
     * @param string $handoverUserId            原跟进成员的userid
     * @param string $takeoverUserId            接替成员的userid
     * @param string $transferSuccessMessage    转移成功后发给客户的消息，最多200个字符，不填则使用默认文案
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException|InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/92125
     *
     */
    public function transferCustomer(array $externalUserId, string $handoverUserId, string $takeoverUserId, string $transferSuccessMessage)
    {
        $params = [
            'external_userid' => $externalUserId,
            'handover_userid' => $handoverUserId,
            'takeover_userid' => $takeoverUserId,
            'transfer_success_msg' => $transferSuccessMessage
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/transfer_customer', $params);
    }

    /**
     * 分配在职或离职成员的客户
     * @deprecated 该接口已不再维护,请使用"分配离职成员的客户接口"
     * @param string $externalUserId    	    客户的external_userid
     * @param string $handoverUserId            原跟进成员的userid
     * @param string $takeoverUserId            接替成员的userid
     * @param string $transferSuccessMessage    转移成功后发给客户的消息，最多200个字符，不填则使用默认文案，目前只对在职成员分配客户的情况生效
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     *
     * @see https://developer.work.weixin.qq.com/document/14020
     */
    public function transfer(string $externalUserId, string $handoverUserId, string $takeoverUserId, string $transferSuccessMessage)
    {
        $params = [
            'external_userid' => $externalUserId,
            'handover_userid' => $handoverUserId,
            'takeover_userid' => $takeoverUserId,
            'transfer_success_msg' => $transferSuccessMessage
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/transfer', $params);
    }

    /**
     * 查询客户接替结果.
     * @deprecated 接口已停止维护
     * @see https://developer.work.weixin.qq.com/document/23225
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @param string $externalUserId 客户的userid，注意不是企业成员的帐号
     * @param string $handoverUserId 原添加成员的userid
     * @param string $takeoverUserId 接替成员的userid
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getTransferResult(string $externalUserId, string $handoverUserId, string $takeoverUserId)
    {
        $params = [
            'external_userid' => $externalUserId,
            'handover_userid' => $handoverUserId,
            'takeover_userid' => $takeoverUserId,
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/get_transfer_result', $params);
    }
}
