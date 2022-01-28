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
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 异步批量接口
 *
 */
class BatchJobsClient extends BaseClient
{
    /**
     * 增量更新成员.
     *
     * @see https://developer.work.weixin.qq.com/document/path/90980
     *
     * @param array $params
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function batchUpdateUsers(array $params)
    {
        return $this->httpPostJson('cgi-bin/batch/syncuser', $params);
    }

    /**
     * 全量覆盖成员.
     *
     * @see https://developer.work.weixin.qq.com/document/path/90981
     *
     * @param array $params
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function batchReplaceUsers(array $params)
    {
        return $this->httpPostJson('cgi-bin/batch/replaceuser', $params);
    }

    /**
     * 全量覆盖部门.
     *
     * @see https://developer.work.weixin.qq.com/document/path/90982
     *
     * @param array $params
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function batchReplaceDepartments(array $params)
    {
        return $this->httpPostJson('cgi-bin/batch/replaceparty', $params);
    }

    /**
     * 获取异步任务结果.
     *
     * @see https://developer.work.weixin.qq.com/document/path/90983
     *
     * @param string $jobId
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getJobStatus(string $jobId)
    {
        $params = [
            'jobid' => $jobId
        ];

        return $this->httpGet('cgi-bin/batch/getresult', $params);
    }
}
