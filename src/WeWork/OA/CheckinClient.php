<?php


namespace WorkWechatSdk\WeWork\OA;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * 打卡
 */
class CheckinClient extends BaseClient
{
    /**
     * 获取打卡记录数据
     *
     * @see https://developer.work.weixin.qq.com/document/path/90262
     *
     * @param int $startTime 获取打卡记录的开始时间。Unix时间戳
     * @param int $endTime 获取打卡记录的结束时间。Unix时间戳
     * @param array $userList 需要获取打卡记录的用户列表
     * @param int $type 打卡类型。1：上下班打卡；2：外出打卡；3：全部打卡
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function checkinRecords(int $startTime, int $endTime, array $userList, int $type = 3)
    {
        $params = [
            'opencheckindatatype' => $type,
            'starttime' => $startTime,
            'endtime' => $endTime,
            'useridlist' => $userList,
        ];

        return $this->httpPostJson('cgi-bin/checkin/getcheckindata', $params);
    }

    /**
     * 获取员工打卡规则
     *
     * @see https://developer.work.weixin.qq.com/document/path/90263
     *
     * @param int $datetime 需要获取规则的日期当天0点的Unix时间戳
     * @param array $userList 需要获取打卡规则的用户列表
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function checkinRules(int $datetime, array $userList)
    {
        $params = [
            'datetime' => $datetime,
            'useridlist' => $userList,
        ];

        return $this->httpPostJson('cgi-bin/checkin/getcheckinoption', $params);
    }

    /**
     * 获取企业所有打卡规则
     *
     * @see https://developer.work.weixin.qq.com/document/path/93384
     *
     * @return ResponseInterface|Collection|array|object|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     */
    public function corpCheckinRules()
    {
        return $this->httpPostJson('cgi-bin/checkin/getcorpcheckinoption');
    }

    /**
     * 获取打卡日报数据.
     *
     * @see https://developer.work.weixin.qq.com/document/path/93374
     *
     * @param int $startTime 获取日报的开始时间。0点Unix时间戳
     * @param int $endTime 获取日报的结束时间。0点Unix时间戳
     * @param array $userids 获取日报的userid列表。单个userid不少于1字节，不多于64字节.可填充个数：1 ~ 100
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     */
    public function checkinDayData(int $startTime, int $endTime, array $userids)
    {
        $params = [
            'starttime' => $startTime,
            'endtime' => $endTime,
            'useridlist' => $userids,
        ];

        return $this->httpPostJson('cgi-bin/checkin/getcheckin_daydata', $params);
    }

    /**
     * 获取打卡月报数据.
     *
     * @sse https://developer.work.weixin.qq.com/document/path/93387
     *
     * @param int $startTime
     * @param int $endTime
     * @param array $userids
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function checkinMonthData(int $startTime, int $endTime, array $userids)
    {
        $params = [
            'starttime' => $startTime,
            'endtime' => $endTime,
            'useridlist' => $userids,
        ];

        return $this->httpPostJson('cgi-bin/checkin/getcheckin_monthdata', $params);
    }

    /**
     * 获取打卡人员排班信息.
     *
     * @sse https://developer.work.weixin.qq.com/document/path/93380
     *
     * @param int $startTime
     * @param int $endTime
     * @param array $userids
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function checkinSchedus(int $startTime, int $endTime, array $userids)
    {
        $params = [
            'starttime' => $startTime,
            'endtime' => $endTime,
            'useridlist' => $userids,
        ];

        return $this->httpPostJson('cgi-bin/checkin/getcheckinschedulist', $params);
    }

    /**
     * 为打卡人员排班.
     *
     * @sse https://developer.work.weixin.qq.com/document/path/93385
     *
     * @param array $params
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     */
    public function setCheckinSchedus(array $params)
    {
        return $this->httpPostJson('cgi-bin/checkin/setcheckinschedulist', $params);
    }

    /**
     * 录入打卡人员人脸信息.
     *
     * @sse https://developer.work.weixin.qq.com/document/path/93378
     *
     * @param string $userid
     * @param string $userface
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     *
     */
    public function addCheckinUserface(string $userid, string $userface)
    {
        $params = [
            'userid' => $userid,
            'userface' => $userface
        ];

        return $this->httpPostJson('cgi-bin/checkin/addcheckinuserface', $params);
    }

    /**
     * 获取设备打卡数据
     * @see https://developer.work.weixin.qq.com/document/path/94126
     * @param int $startTime
     * @param int $endTime
     * @param array $useridList
     * @param int $filterType
     * @return array|object|ResponseInterface|string|Collection
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function getHardwareCheckinData(int $startTime, int $endTime, array $useridList, int $filterType = 1)
    {
        $params = [
            "filter_type" => $filterType,
            "starttime" => $startTime,
            "endtime" => $endTime,
            "useridlist" => $useridList
        ];

        return $this->httpPostJson('/cgi-bin/hardware/get_hardware_checkin_data', $params);
    }
}
