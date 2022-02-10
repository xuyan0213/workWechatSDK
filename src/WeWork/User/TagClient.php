<?php


namespace WorkWechatSdk\WeWork\User;

use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 标签管理
 */
class TagClient extends BaseClient
{
    /**
     * 创建标签
     *
     * @see https://developer.work.weixin.qq.com/document/path/90210
     *
     * @param string   $tagName 标签名称，长度限制为32个字以内（汉字或英文字母），标签名不可与其他标签重名。
     * @param int|null $tagId 标签id，非负整型，指定此参数时新增的标签会生成对应的标签id，不指定时则以目前最大的id自增。
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws InvalidConfigException
     * 
     */
    public function create(string $tagName, int $tagId = null)
    {
        $params = [
            'tagname' => $tagName,
            'tagid' => $tagId,
        ];
        return $this->httpPostJson('cgi-bin/tag/create', $params);
    }

    /**
     * 更新标签名字
     *
     * @see https://developer.work.weixin.qq.com/document/path/90211
     *
     * @param int    $tagId
     * @param string $tagName
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * 
     */
    public function update(int $tagId, string $tagName)
    {
        $params = [
            'tagid' => $tagId,
            'tagname' => $tagName,
        ];

        return $this->httpPostJson('cgi-bin/tag/update', $params);
    }

    /**
     * 删除标签
     *
     * @see https://developer.work.weixin.qq.com/document/path/90212
     *
     * @param int $tagId
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     */
    public function delete(int $tagId)
    {
        return $this->httpGet('cgi-bin/tag/delete', ['tagid' => $tagId]);
    }

    /**
     * 获取标签成员
     *
     * @see https://developer.work.weixin.qq.com/document/path/90213
     *
     * @param int $tagId
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     */
    public function get(int $tagId)
    {
        return $this->httpGet('cgi-bin/tag/get', ['tagid' => $tagId]);
    }

    /**
     * 增加标签成员(企业成员ID)
     * @see https://developer.work.weixin.qq.com/document/path/90214
     * @param int   $tagId
     * @param array $userList
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * 
     */
    public function tagUsers(int $tagId, array $userList = [])
    {
        return $this->tagOrUntagUsers('cgi-bin/tag/addtagusers', $tagId, $userList);
    }

    /**
     * 增加标签成员(部门ID)
     * @see https://developer.work.weixin.qq.com/document/path/90214
     *
     * @param int   $tagId
     * @param array $partyList
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * 
     */
    public function tagDepartments(int $tagId, array $partyList = [])
    {
        return $this->tagOrUntagUsers('cgi-bin/tag/addtagusers', $tagId, [], $partyList);
    }

    /**
     * 删除标签成员(通过企业成员ID)
     * https://developer.work.weixin.qq.com/document/path/90215
     * @param int   $tagId
     * @param array $userList
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * 
     */
    public function untagUsers(int $tagId, array $userList = [])
    {
        return $this->tagOrUntagUsers('cgi-bin/tag/deltagusers', $tagId, $userList);
    }

    /**
     *      * 删除标签成员(通过企业部门ID)
     * https://developer.work.weixin.qq.com/document/path/90215
     * @param int   $tagId
     * @param array $partyList
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * 
     */
    public function untagDepartments(int $tagId, array $partyList = [])
    {
        return $this->tagOrUntagUsers('cgi-bin/tag/deltagusers', $tagId, [], $partyList);
    }

    /**
     * @param string $endpoint
     * @param int    $tagId
     * @param array  $userList
     * @param array  $partyList
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * 
     */
    protected function tagOrUntagUsers(string $endpoint, int $tagId, array $userList = [], array $partyList = [])
    {
        $data = [
            'tagid' => $tagId,
            'userlist' => $userList,
            'partylist' => $partyList,
        ];

        return $this->httpPostJson($endpoint, $data);
    }

    /**
     * 获取标签列表
     * @see https://developer.work.weixin.qq.com/document/path/90216
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     */
    public function list()
    {
        return $this->httpGet('cgi-bin/tag/list');
    }
}
