<?php


namespace WorkWechatSdk\WeWork\ExternalContact;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * Class StatisticsClient.
 *
 */
class StatisticsClient extends BaseClient
{
    /**
     * 获取「联系客户统计」数据.
     *
     * @see https://developer.work.weixin.qq.com/document/path/92132
     *
     * @param array $userIds 成员ID列表，最多100个
     * @param string $from 数据起始时间
     * @param string $to 数据结束时间
     * @param array $partyIds 部门ID列表，最多100个
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException|GuzzleException
     */

    public function userBehavior(array $userIds, string $from, string $to, array $partyIds = [])
    {
        $params = [
            'userid' => $userIds,
            'partyid' => $partyIds,
            'start_time' => $from,
            'end_time' => $to,
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/get_user_behavior_data', $params);
    }


    /**
     * 获取「群聊数据统计」数据. (按群主聚合的方式)
     *
     * @see https://work.weixin.qq.com/api/doc/90000/90135/92133
     *
     * @param array $params
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */

    public function groupChatStatistic(array $params)
    {
        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/statistic', $params);
    }


    /**
     * 获取「群聊数据统计」数据. (按自然日聚合的方式)
     *
     * @see https://developer.work.weixin.qq.com/document/path/92133#按自然日聚合的方式
     *
     * @param int $dayBeginTime 起始日期的时间戳，填当天的0时0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前180天。
     * @param int $dayEndTime 结束日期的时间戳，填当天的0时0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前180天。如果不填，默认同 day_begin_time（即默认取一天的数据）
     * @param array $userIds 群主ID列表。最多100个 群主过滤 如果不填，表示获取应用可见范围内全部群主的数据（但是不建议这么用，如果可见范围人数超过1000人，为了防止数据包过大，会报错 81017）
     * @param int $orderBy 排序方式。1:新增群的数量, 2:群总数,3:新增群人数, 4:群总人数,默认为1
     * @param int $orderAsc 是否升序。0-否；1-是。默认降序
     * @param int $offset 分页，偏移量, 默认为0
     * @param int $limit 分页，预期请求的数据量，默认为500，取值范围 1 ~ 1000
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function groupChatStatisticGroupByDay(int $dayBeginTime, int $dayEndTime, int $orderBy, int $orderAsc, int $offset, int $limit, array $userIds = [])
    {
        $params = [
            'day_begin_time' => $dayBeginTime,
            'day_end_time' => $dayEndTime,
            'owner_filter' => [
                'userid_list' => $userIds
            ],
            'order_by' => $orderBy,
            'order_asc' => $orderAsc,
            'offset' => $offset,
            'limit' => $limit
        ];
        return $this->httpPostJson('cgi-bin/externalcontact/groupchat/statistic_group_by_day', $params);
    }
}
