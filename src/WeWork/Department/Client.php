<?php


namespace WorkWechatSdk\WeWork\Department;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 部门管理
 *
 */
class Client extends BaseClient
{
    /**
     * 创建部门
     *
     * @param array $data
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/90205
     */
    public function create(array $data)
    {
        return $this->httpPostJson('cgi-bin/department/create', $data);
    }

    /**
     * 更新部门
     *
     * @param int   $id 	部门id
     * @param array $data
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/90206
     */
    public function update(int $id, array $data)
    {
        return $this->httpPostJson('cgi-bin/department/update', array_merge(compact('id'), $data));
    }

    /**
     * 删除部门
     *
     * @param int $id 	部门id。（注：不能删除根部门；不能删除含有子部门、成员的部门）
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/90207
     */
    public function delete(int $id)
    {
        return $this->httpGet('cgi-bin/department/delete', compact('id'));
    }

    /**
     * 获取子部门ID列表
     *
     * @param int|null $id 	部门id。获取指定部门及其下的子部门（以及子部门的子部门等等，递归）。 如果不填，默认获取全量组织架构
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     *
     * @see https://developer.work.weixin.qq.com/document/path/95350
     */
    public function simpleList(int $id = null)
    {
        return $this->httpGet('cgi-bin/department/simplelist', compact('id'));
    }

    /**
     * 获取单个部门详情
     *
     * @param int $id 部门ID
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     *
     * @see https://developer.work.weixin.qq.com/document/path/95351
     */
    public function get(int $id)
    {
        return $this->httpGet('cgi-bin/department/simplelist', compact('id'));
    }

    /**
     * 获取部门列表
     * (注：该接口性能较低，建议换用获取子部门ID列表与获取单个部门详情)
     * @param int|null $id 	部门id。获取指定部门及其下的子部门（以及子部门的子部门等等，递归）。 如果不填，默认获取全量组织架构
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     *
     * @see https://developer.work.weixin.qq.com/document/path/90208
     */
    public function list(int $id = null)
    {
        return $this->httpGet('cgi-bin/department/list', compact('id'));
    }
}
