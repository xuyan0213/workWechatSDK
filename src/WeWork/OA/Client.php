<?php


namespace WorkWechatSdk\WeWork\OA;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 审批
 */
class Client extends BaseClient
{
    /**
     * Get approval template details.
     *
     * @param string $templateId
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function approvalTemplate(string $templateId)
    {
        $params = [
            'template_id' => $templateId,
        ];

        return $this->httpPostJson('cgi-bin/oa/gettemplatedetail', $params);
    }

    /**
     * Submit an application for approval.
     *
     * @param array $data
     *
     * @return mixed
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function createApproval(array $data)
    {
        return $this->httpPostJson('cgi-bin/oa/applyevent', $data);
    }

    /**
     * Get Approval number.
     *
     * @param int   $startTime
     * @param int   $endTime
     * @param int   $nextCursor
     * @param int   $size
     * @param array $filters
     *
     * @return mixed
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function approvalNumbers(int $startTime, int $endTime, int $nextCursor = 0, int $size = 100, array $filters = [])
    {
        $params = [
            'starttime' => $startTime,
            'endtime' => $endTime,
            'cursor' => $nextCursor,
            'size' => $size > 100 ? 100 : $size,
            'filters' => $filters,
        ];

        return $this->httpPostJson('cgi-bin/oa/getapprovalinfo', $params);
    }

    /**
     * Get approval detail.
     *
     * @param int $number
     *
     * @return mixed
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function approvalDetail(int $number)
    {
        $params = [
            'sp_no' => $number,
        ];

        return $this->httpPostJson('cgi-bin/oa/getapprovaldetail', $params);
    }

    /**
     * Get Approval Data.
     *
     * @param int $startTime
     * @param int $endTime
     * @param int|null $nextNumber
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function approvalRecords(int $startTime, int $endTime, int $nextNumber = null)
    {
        $params = [
            'starttime' => $startTime,
            'endtime' => $endTime,
            'next_spnum' => $nextNumber,
        ];

        return $this->httpPostJson('cgi-bin/corp/getapprovaldata', $params);
    }


    /**
     * 获取公费电话拨打记录.
     *
     * @param int $startTime
     * @param int $endTime
     * @param int $offset
     * @param int $limit
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function dialRecords(int $startTime, int $endTime, int $offset = 0, $limit = 100)
    {
        $params = [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'offset' => $offset,
            'limit' => $limit
        ];

        return $this->httpPostJson('cgi-bin/dial/get_dial_record', $params);
    }
}
