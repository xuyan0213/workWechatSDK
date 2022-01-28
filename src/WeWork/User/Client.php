<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\WeWork\User;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 成员管理
 *
 */
class Client extends BaseClient
{
    /**
     * 创建成员
     *
     * @see https://developer.work.weixin.qq.com/document/path/90195
     *
     * @param array $data
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function create(array $data)
    {
        return $this->httpPostJson('cgi-bin/user/create', $data);
    }

    /**
     * 读取成员
     *
     * @see https://developer.work.weixin.qq.com/document/path/90196
     * @param string $userId
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function get(string $userId)
    {
        return $this->httpGet('cgi-bin/user/get', ['userid' => $userId]);
    }

    /**
     * 更新成员
     *
     * @see https://developer.work.weixin.qq.com/document/path/90197
     *
     * @param string $id
     * @param array  $data
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function update(string $id, array $data)
    {
        return $this->httpPostJson('cgi-bin/user/update', array_merge(['userid' => $id], $data));
    }

    /**
     * 删除成员
     *
     * @see https://developer.work.weixin.qq.com/document/path/90198
     *
     * @param string|array $userId
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function delete($userId)
    {
        if (is_array($userId)) {
            return $this->batchDelete($userId);
        }

        return $this->httpGet('cgi-bin/user/delete', ['userid' => $userId]);
    }

    /**
     * 批量删除成员
     *
     * @see https://developer.work.weixin.qq.com/document/path/90199
     *
     * @param array $userIds
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function batchDelete(array $userIds)
    {
        return $this->httpPostJson('cgi-bin/user/batchdelete', ['useridlist' => $userIds]);
    }



    /**
     * 获取部门成员
     *
     * @see https://developer.work.weixin.qq.com/document/path/90200
     * @param int  $departmentId
     * @param bool $fetchChild
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function getDepartmentUsers(int $departmentId, bool $fetchChild = false)
    {
        $params = [
            'department_id' => $departmentId,
            'fetch_child' => (int) $fetchChild,
        ];

        return $this->httpGet('cgi-bin/user/simplelist', $params);
    }

    /**
     * 获取部门成员详情
     *
     * @see https://developer.work.weixin.qq.com/document/path/90201
     *
     * @param int  $departmentId
     * @param bool $fetchChild
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function getDetailedDepartmentUsers(int $departmentId, bool $fetchChild = false)
    {
        $params = [
            'department_id' => $departmentId,
            'fetch_child' => (int) $fetchChild,
        ];

        return $this->httpGet('cgi-bin/user/list', $params);
    }

    /**
     * userid与openid互换 userid转openid
     *
     * @see https://developer.work.weixin.qq.com/document/path/90202
     *
     * @param string $userId
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function userIdToOpenid(string $userId)
    {
        $params = [
            'userid' => $userId
        ];

        return $this->httpPostJson('cgi-bin/user/convert_to_openid', $params);
    }

    /**
     * userid与openid互换.openid转userid
     *
     * @see https://developer.work.weixin.qq.com/document/path/90202
     *
     * @param string $openid
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function openidToUserId(string $openid)
    {
        $params = [
            'openid' => $openid,
        ];

        return $this->httpPostJson('cgi-bin/user/convert_to_userid', $params);
    }

    /**
     * 手机号获取userid
     *
     * @see https://developer.work.weixin.qq.com/document/path/95402
     *
     * @param string $mobile
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function mobileToUserId(string $mobile)
    {
        $params = [
            'mobile' => $mobile,
        ];

        return $this->httpPostJson('cgi-bin/user/getuserid', $params);
    }

    /**
     * 二次验证
     *
     * @see https://developer.work.weixin.qq.com/document/path/90203
     *
     * @param string $userId
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException|GuzzleException
     */
    public function accept(string $userId)
    {
        $params = [
            'userid' => $userId,
        ];

        return $this->httpGet('cgi-bin/user/authsucc', $params);
    }

    /**
     * 邀请成员
     *
     * @see https://developer.work.weixin.qq.com/document/path/90975
     *
     * @param array $params
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function invite(array $params)
    {
        return $this->httpPostJson('cgi-bin/batch/invite', $params);
    }

    /**
     * 获取加入企业二维码
     *
     * @see https://developer.work.weixin.qq.com/document/path/91714
     *
     * @param int $sizeType
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException|GuzzleException
     */
    public function getInvitationQrCode(int $sizeType = 1)
    {
        if (!\in_array($sizeType, [1, 2, 3, 4], true)) {
            throw new InvalidArgumentException('The sizeType must be 1, 2, 3, 4.');
        }

        return $this->httpGet('cgi-bin/corp/get_join_qrcode', ['size_type' => $sizeType]);
    }

    /**
     * 获取企业活跃成员数
     *
     * @see https://developer.work.weixin.qq.com/document/path/92714
     *
     * @param string $date
     * @return array|Collection|object|ResponseInterface|string
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getActiveStat(string $date)
    {
        $params = [
            'date'=>$date
        ];
        return $this->httpPostJson('/cgi-bin/user/get_active_stat', $params);
    }
}
