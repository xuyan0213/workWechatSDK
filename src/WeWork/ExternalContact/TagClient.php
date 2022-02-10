<?php


namespace WorkWechatSdk\WeWork\ExternalContact;

use WorkWechatSdk\Kernel\BaseClient;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 客户标签管理
 *
 */
class TagClient extends BaseClient
{
    /**
     * 获取企业标签库.
     *
     * @see https://developer.work.weixin.qq.com/document/path/92117#获取企业标签库
     *
     * @param array $tagIds 要查询的标签id
     * @param array $groupIds 要查询的标签组id，返回该标签组以及其下的所有标签信息
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * 
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
     * @see https://developer.work.weixin.qq.com/document/path/92117#添加企业客户标签
     *
     * @param array $tags 标签
     * @param string $groupId 标签组id
     * @param string $groupName 标签组名称，最长为30个字符
     * @param array $attributes
     * @return array|Collection|object|ResponseInterface|string
     *
     * 
     * @throws InvalidConfigException
     */

    public function addCorpTag(array $tags, string $groupId, string $groupName, array $attributes)
    {
        $params = [
            'group_id' => $groupId,
            'group_name' => $groupName,
            'tag' => $tags
        ];
        $params = empty($attributes) ? $params : array_merge($params, $attributes);
        return $this->httpPostJson('cgi-bin/externalcontact/add_corp_tag', $params);
    }


    /**
     * 编辑企业客户标签.
     *
     * @see https://developer.work.weixin.qq.com/document/path/92117#编辑企业客户标签
     *
     * @param string $id
     * @param string|null $name
     * @param int|null $order
     * @param int|null $agentId
     * @return array|Collection|object|ResponseInterface|string
     *
     * 
     * @throws InvalidConfigException
     */

    public function updateCorpTag(string $id, string $name = null, int $order = null, int $agentId = null)
    {
        $params = [
            "id" => $id,
            'name' => $name,
            'order' => $order,
            'agentid' => $agentId
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/edit_corp_tag', $params);
    }


    /**
     * 删除企业客户标签.
     *
     * @see https://developer.work.weixin.qq.com/document/path/92117#删除企业客户标签
     *
     * @param array $tagId
     * @param array $groupId
     * @param int|null $agentId
     * @return array|Collection|object|ResponseInterface|string
     *
     * 
     * @throws InvalidConfigException
     */

    public function deleteCorpTag(array $tagId, array $groupId, int $agentId)
    {
        $params = [
            "tag_id" => $tagId,
            "group_id" => $groupId,
            'agentid' => $agentId
        ];

        return $this->httpPostJson('cgi-bin/externalcontact/del_corp_tag', $params);
    }


    /**
     * 编辑客户企业标签.
     *
     * @see https://work.weixin.qq.com/api/doc/90000/90135/92118
     *
     * @param string $userId 添加外部联系人的userid
     * @param string $externalUserId 外部联系人userid
     * @param array $addTag 要标记的标签列表
     * @param array $removeTag 要移除的标签列表
     * @return array|Collection|object|ResponseInterface|string
     *
     * 
     * @throws InvalidConfigException
     */

    public function markTags(string $userId, string $externalUserId, array $addTag, array $removeTag)
    {
        $params = [
            'userid' => $userId,
            'external_userid' => $externalUserId,
            'add_tag' => $addTag,
            'remove_tag' => $removeTag
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/mark_tag', $params);
    }
}
