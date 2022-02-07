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
     * 获取审批模板详情
     *
     * @see https://developer.work.weixin.qq.com/document/path/91982
     *
     * @param string $templateId
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getTemplateDetail(string $templateId)
    {
        $params = [
            'template_id' => $templateId,
        ];

        return $this->httpPostJson('cgi-bin/oa/gettemplatedetail', $params);
    }

    /**
     * 提交审批申请
     *
     * @see https://developer.work.weixin.qq.com/document/path/91853
     *
     * @param string $creatorUserid 申请人userid，此审批申请将以此员工身份提交，申请人需在应用可见范围内
     * @param string $templateId 模板id。
     * @param array $approver 审批流程信息，用于指定审批申请的审批流程，支持单人审批、多人会签、多人或签，可能有多个审批节点，仅use_template_approver为0时生效。
     * @param array $applyData 审批申请数据，可定义审批申请中各个控件的值，其中必填项必须有值，选填项可为空，数据结构同“获取审批申请详情”接口返回值中同名参数“apply_data”
     * @param array $summaryList 摘要信息，用于显示在审批通知卡片、审批列表的摘要信息，最多3行
     * @param int $useTemplateApprover 审批人模式：0-通过接口指定审批人、抄送人（此时approver、notifyer等参数可用）; 1-使用此模板在管理后台设置的审批流程，支持条件审批。默认为0
     * @param int|null $department 提单者提单部门id，不填默认为主部门
     * @param int $notifyType 抄送方式：1-提单时抄送（默认值）； 2-单据通过后抄送；3-提单和单据通过后抄送。仅use_template_approver为0时生效。
     * @param array $notifyer 抄送人节点userid列表，仅use_template_approver为0时生效。
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function applyEvent(string $creatorUserid, string $templateId, array $approver, array $applyData, array $summaryList, int $useTemplateApprover = 0, int $department = null, int $notifyType = 1, $notifyer = [])
    {
        $params = [
            "creator_userid" => $creatorUserid,
            "template_id" => $templateId,
            "use_template_approver" => $useTemplateApprover,
            "choose_department" => $department,
            "approver" => $approver,
            "notifyer" => $notifyer,
            "notify_type" => $notifyType,
            "apply_data" => $applyData,
            "summary_list" => $summaryList
        ];
        return $this->httpPostJson('cgi-bin/oa/applyevent', $params);
    }

    /**
     * 批量获取审批单号
     *
     * @see https://developer.work.weixin.qq.com/document/path/91816
     *
     * @param int $startTime 审批单提交的时间范围，开始时间，UNix时间戳
     * @param int $endTime 审批单提交的时间范围，结束时间，Unix时间戳
     * @param int $nextCursor 分页查询游标，默认为0，后续使用返回的next_cursor进行分页拉取
     * @param int $size 一次请求拉取审批单数量，默认值为100，上限值为100。
     * @param array $filters 筛选条件，可对批量拉取的审批申请设置约束条件，支持设置多个条件
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getApprovalInfo(int $startTime, int $endTime, int $nextCursor = 0, int $size = 100, array $filters = [])
    {
        $params = [
            'starttime' => $startTime,
            'endtime' => $endTime,
            'cursor' => $nextCursor,
            'size' => min($size, 100),
            'filters' => $filters,
        ];

        return $this->httpPostJson('cgi-bin/oa/getapprovalinfo', $params);
    }

    /**
     * 获取审批申请详情
     *
     * @see https://developer.work.weixin.qq.com/document/path/91983
     *
     * @param int $number
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function getApprovalDetail(int $number)
    {
        $params = [
            'sp_no' => $number,
        ];

        return $this->httpPostJson('cgi-bin/oa/getapprovaldetail', $params);
    }

    /**
     * 获取审批数据（旧）
     *
     * @see https://developer.work.weixin.qq.com/document/path/91530
     *
     * @param int $startTime 获取审批记录的开始时间。Unix时间戳
     * @param int $endTime 获取审批记录的结束时间。Unix时间戳
     * @param int|null $nextNumber 第一个拉取的审批单号，不填从该时间段的第一个审批单拉取
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getApprovalData(int $startTime, int $endTime, int $nextNumber = null)
    {
        $params = [
            'starttime' => $startTime,
            'endtime' => $endTime,
            'next_spnum' => $nextNumber,
        ];

        return $this->httpPostJson('cgi-bin/corp/getapprovaldata', $params);
    }


    /**
     * 获取企业假期管理配置
     *
     * @see https://developer.work.weixin.qq.com/document/path/93375
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getCorpConf()
    {
        return $this->httpPostJson('cgi-bin/oa/vacation/getcorpconf');
    }

    /**
     * 获取成员假期余额
     *
     * @see https://developer.work.weixin.qq.com/document/path/93376
     *
     * @param string $userid
     * @return array|object|ResponseInterface|string|Collection
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getUserVacationQuota(string $userid)
    {
        $params = [
            'userid' => $userid
        ];
        return $this->httpPostJson('cgi-bin/oa/vacation/getuservacationquota', $params);
    }

    /**
     * 修改成员假期余额
     *
     * @see https://developer.work.weixin.qq.com/document/path/93377
     *
     * @param string $userid
     * @param int $vacationId
     * @param int $leftDuration
     * @param int $timeAttr
     * @param string $remarks
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function setOneUserQuota(string $userid,int $vacationId, int $leftDuration,int $timeAttr,string $remarks = '')
    {
        $params = [
            'userid' => $userid,
            "vacation_id" => $vacationId,
            "leftduration" => $leftDuration,
            "time_attr" => $timeAttr,
            "remarks" => $remarks
        ];
        return $this->httpPostJson('cgi-bin/oa/vacation/setoneuserquota', $params);
    }
}
