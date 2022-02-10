<?php


namespace WorkWechatSdk\WeWork\User;

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
     * @param string $mediaId 上传的csv文件的media_id
     * @param bool $toInvite    是否邀请新建的成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日），默认值为true。
     * @param array $callback 回调信息。如填写该项则任务完成后，通过callback推送事件给企业。具体请参考应用回调模式中的相应选项
     * @return ResponseInterface|Collection|array|object|string
     *
     * 
     * @throws InvalidConfigException
     */
    public function batchUpdateUsers(string $mediaId, bool $toInvite = true, array $callback = [])
    {
        $params = [
            "media_id" => $mediaId,
            "to_invite" => $toInvite,
            "callback" => $callback
        ];
        return $this->httpPostJson('cgi-bin/batch/syncuser', $params);
    }

    /**
     * 全量覆盖成员.
     *
     * @see https://developer.work.weixin.qq.com/document/path/90981
     *
     * @param string $mediaId
     * @param bool $toInvite
     * @param array $callback
     * @return ResponseInterface|Collection|array|object|string
     *
     * 
     * @throws InvalidConfigException
     */
    public function batchReplaceUsers(string $mediaId, bool $toInvite = true, array $callback = [])
    {
        $params = [
            "media_id" => $mediaId,
            "to_invite" => $toInvite,
            "callback" => $callback
        ];
        return $this->httpPostJson('cgi-bin/batch/replaceuser', $params);
    }

    /**
     * 全量覆盖部门.
     *
     * @see https://developer.work.weixin.qq.com/document/path/90982
     *
     * @param string $mediaId
     * @param bool $toInvite
     * @param array $callback
     * @return ResponseInterface|Collection|array|object|string
     *
     * 
     * @throws InvalidConfigException
     */
    public function batchReplaceDepartments(string $mediaId, bool $toInvite = true, array $callback = [])
    {
        $params = [
            "media_id" => $mediaId,
            "to_invite" => $toInvite,
            "callback" => $callback
        ];
        return $this->httpPostJson('cgi-bin/batch/replaceparty', $params);
    }

    /**
     * 获取异步任务结果.
     *
     * @see https://developer.work.weixin.qq.com/document/path/90983
     *
     * @param string $jobId 异步任务id，最大长度为64字节
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * 
     */
    public function getJobStatus(string $jobId)
    {
        $params = [
            'jobid' => $jobId
        ];

        return $this->httpGet('cgi-bin/batch/getresult', $params);
    }
}
