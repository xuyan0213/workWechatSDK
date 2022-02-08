<?php


namespace WorkWechatSdk\WeWork\User;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 部门管理
 *
 */
class DepartmentClient extends BaseClient
{
    /**
     * 创建部门
     *
     * @param string $name  部门名称。同一个层级的部门名称不能重复。
     * @param int $parentId 父部门id，32位整型
     * @param string $enName 英文名称。同一个层级的部门名称不能重复。
     * @param int|null $order 在父部门中的次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * @param int|null $id 部门id，32位整型，指定时必须大于1。若不填该参数，将自动生成id
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/90205
     */
    public function create(string $name, int $parentId, string $enName = null, int $order = null, int $id = null)
    {
        $params = [
            "name" => $name,
            "name_en" => $enName,
            "parentid" => $parentId,
            "order" => $order,
            "id" => $id
        ];
        return $this->httpPostJson('cgi-bin/department/create', $params);
    }

    /**
     * 更新部门
     *
     * @param int $id 部门id
     * @param string $name
     * @param int $parentId
     * @param string|null $enName
     * @param int|null $order
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @see https://developer.work.weixin.qq.com/document/path/90206
     */
    public function update(int $id, string $name, int $parentId, string $enName = null, int $order = null)
    {
        $params = [
            "id" => $id,
            "name" => $name,
            "name_en" => $enName,
            "parentid" => $parentId,
            "order" => $order
        ];
        return $this->httpPostJson('cgi-bin/department/update', $params);
    }

    /**
     * 删除部门
     *
     * @param int $id 部门id。（注：不能删除根部门；不能删除含有子部门、成员的部门）
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
     * @param int|null $id 部门id。获取指定部门及其下的子部门（以及子部门的子部门等等，递归）。 如果不填，默认获取全量组织架构
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
        return $this->httpGet('cgi-bin/department/get', compact('id'));
    }

    /**
     * 获取部门列表
     * (注：该接口性能较低，建议换用获取子部门ID列表与获取单个部门详情)
     * @param int|null $id 部门id。获取指定部门及其下的子部门（以及子部门的子部门等等，递归）。 如果不填，默认获取全量组织架构
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
