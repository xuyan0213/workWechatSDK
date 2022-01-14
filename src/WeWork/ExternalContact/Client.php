<?php


namespace WorkWechatSdk\WeWork\ExternalContact;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 客户管理
 *
 */
class Client extends BaseClient
{
    /**
     * 获取外部联系人列表.
     *
     * @param string $userId 	企业成员的userid
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92113
     */
    public function list(string $userId)
    {
        return $this->httpGet('cgi-bin/externalcontact/list', [
            'userid' => $userId,
        ]);
    }

    /**
     * 批量获取客户详情.
     *
     * @param array $userIdList 企业成员的userid列表，字符串类型，最多支持100个
     * @param string $cursor    用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     * @param integer $limit    返回的最大记录数，整型，最大值100，默认值50，超过最大值时取最大值
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92994
     */
    public function batchGet(array $userIdList, string $cursor = '', int $limit = 100)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/batch/get_by_user', [
            'userid_list' => $userIdList,
            'cursor' => $cursor,
            'limit' => $limit,
        ]);
    }

    /**
     * 获取外部联系人详情.
     *
     * @param string $externalUserId 外部联系人的userid，注意不是企业成员的帐号
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92114
     */
    public function get(string $externalUserId)
    {
        return $this->httpGet('cgi-bin/externalcontact/get', [
            'external_userid' => $externalUserId,
        ]);
    }

    /**
     * 批量获取外部联系人详情.
     *
     * @see https://work.weixin.qq.com/api/doc/90001/90143/93010
     *
     * @param array $userIdList
     * @param string $cursor
     * @param int $limit
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function batchGetByUser(array $userIdList, string $cursor, int $limit)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/batch/get_by_user', [
            'userid_list' => $userIdList,
            'cursor' => $cursor,
            'limit' => $limit
        ]);
    }


    /**
     * 修改客户备注信息.
     *
     * @param string $userid            企业成员的userid
     * @param string $externalUserId    外部联系人userid
     * @param array $data
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     *
     * @see https://developer.work.weixin.qq.com/document/path/92115
     */
    public function remark(string $userid, string $externalUserId,array $data)
    {
        $params = array_merge([
            'userid' => $userid,
            'external_userid' => $externalUserId
        ], $data);
        return $this->httpPostJson('cgi-bin/externalcontact/remark', $params);
    }






    /**
     * 获取企业标签库.
     *
     * @see https://work.weixin.qq.com/api/doc/90000/90135/92117#获取企业标签库
     *
     * @param array $tagIds
     * @param array $groupIds
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */

    public function getCorpTags(array $tagIds = [], array $groupIds = [])
    {
        $params = [
            'tag_id' => $tagIds,
            'group_id' => $groupIds
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/get_corp_tag_list', $params);
    }


    /**
     * 添加企业客户标签.
     *
     * @see https://work.weixin.qq.com/api/doc/90000/90135/92117#添加企业客户标签
     *
     * @param array $params
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */

    public function addCorpTag(array $params)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/add_corp_tag', $params);
    }


    /**
     * 编辑企业客户标签.
     *
     * @see https://work.weixin.qq.com/api/doc/90000/90135/92117#编辑企业客户标签
     *
     * @param string $id
     * @param string|null $name
     * @param int|null $order
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */

    public function updateCorpTag(string $id, ?string $name = null, ?int $order = null)
    {
        $params = [
            "id" => $id
        ];

        if (!\is_null($name)) {
            $params['name'] = $name;
        }

        if (!\is_null($order)) {
            $params['order'] = $order;
        }

        return $this->httpPostJson('cgi-bin/externalcontact/edit_corp_tag', $params);
    }


    /**
     * 删除企业客户标签.
     *
     * @see https://work.weixin.qq.com/api/doc/90000/90135/92117#删除企业客户标签
     *
     * @param array $tagId
     * @param array $groupId
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */

    public function deleteCorpTag(array $tagId, array $groupId)
    {
        $params = [
            "tag_id" => $tagId,
            "group_id" => $groupId,
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/del_corp_tag', $params);
    }


    /**
     * 编辑客户企业标签.
     *
     * @see https://work.weixin.qq.com/api/doc/90000/90135/92118
     *
     * @param array $params
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */

    public function markTags(array $params)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/mark_tag', $params);
    }

    /**
     * 外部联系人unionid转换.
     *
     * @see https://work.weixin.qq.com/api/doc/90001/90143/93274
     *
     * @param string|null $unionid 微信客户的unionid
     * @param string|null $openid 微信客户的openid
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function unionidToExternalUserid(?string $unionid = null, ?string $openid = null)
    {
        return $this->httpPostJson(
            'cgi-bin/externalcontact/unionid_to_external_userid',
            [
                'unionid' => $unionid,
                'openid' => $openid,
            ]
        );
    }

    /**
     * 代开发应用external_userid转换.
     *
     * @see https://work.weixin.qq.com/api/doc/90001/90143/95195
     *
     * @param string $externalUserid 代开发自建应用获取到的外部联系人ID
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function toServiceExternalUserid(string $externalUserid)
    {
        return $this->httpPostJson(
            'cgi-bin/externalcontact/to_service_external_userid',
            [
                'external_userid' => $externalUserid,
            ]
        );
    }


    /**
     * 转换external_userid
     *
     * @see https://open.work.weixin.qq.com/api/doc/90001/90143/95327
     *
     * @param array $externalUserIds
     *
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function getNewExternalUserid(array $externalUserIds)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/get_new_external_userid', ['external_userid_list' => $externalUserIds]);
    }

    /**
     * 设置迁移完成
     *
     * @see https://open.work.weixin.qq.com/api/doc/90001/90143/95327
     *
     * @param string $corpid
     *
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function finishExternalUseridMigration(string $corpid)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/finish_external_userid_migration', ['corpid' => $corpid]);
    }

    /**
     * unionid查询external_userid
     *
     * @see https://open.work.weixin.qq.com/api/doc/90001/90143/95327
     *
     * @param string $unionid
     * @param string $openid
     * @param string $corpid
     *
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function unionidToexternalUserid3rd(string $unionid, string $openid, string $corpid = '')
    {
        $params = [
            'unionid' => $unionid,
            'openid' => $openid,
            'corpid' => $corpid
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/unionid_to_external_userid_3rd', $params);
    }


    /**
     * 客户群opengid转换
     *
     * @see https://work.weixin.qq.com/api/doc/90000/90135/94822
     * @param string $opengid 小程序在微信获取到的群ID
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function opengidToChatid(string $opengid)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/opengid_to_chatid', compact('opengid'));
    }


    /**
     * 上传附件资源
     *
     * @see https://work.weixin.qq.com/api/doc/90000/90135/95098
     * @param string $path 附件资源路径
     * @param string $mediaType 媒体文件类型
     * @param string attachmentType 附件类型
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function uploadAttachment(string $path, string $mediaType, string $attachmentType)
    {
        $query = [
            'media_type' => $mediaType,
            'attachment_type' => $attachmentType,
        ];

        return $this->httpUpload('cgi-bin/media/upload_attachment', ['media' => $path], [], $query);
    }
}
