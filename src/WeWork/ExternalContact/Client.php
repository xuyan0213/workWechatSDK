<?php


namespace WorkWechatSdk\WeWork\ExternalContact;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 客户联系-客户管理
 */
class Client extends BaseClient
{
    /**
     * 获取客户列表
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
    public function unionidToExternalUserid(string $unionid = null, string $openid = null)
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
     * 上传附件资源
     *
     * @see https://developer.work.weixin.qq.com/document/path/95098
     * @param string $path 附件资源路径
     * @param string $mediaType 媒体文件类型 分别有图片（image）、视频（video）、普通文件（file）
     * @param string attachmentType 附件类型,不同的附件类型用于不同的场景。1：朋友圈；2:商品图册
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
