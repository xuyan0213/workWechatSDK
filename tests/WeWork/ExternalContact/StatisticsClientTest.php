<?php

namespace WorkWechatSdk\Tests\WeWork\ExternalContact;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\ExternalContact\StatisticsClient as Client;

/**
 * 客户联系-统计管理
 */
class StatisticsClientTest extends TestCase
{

    /**
     * 获取「联系客户统计」数据
     * @return void
     */
    public function testUserBehavior()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'userid' => ['aaa','bbb'],
            'partyid' => [],
            'start_time' => strtotime('2022-01-01'),
            'end_time' => strtotime('2022-01-30'),
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_user_behavior_data', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->userBehavior([
            'aaa',
            'bbb',
        ],  '2022-01-01','2022-01-30',[]
        ));
    }

    /**
     * 获取「群聊数据统计」数据. (按群主聚合的方式)
     * @return void
     */
    public function testGroupChatStatistic()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "day_begin_time" => 1600272000,
            "day_end_time" => 1600444800,
            "owner_filter" => [
                "userid_list" => [
                    "zhangsan"
                ]
            ],
            "order_by" => 2,
            "order_asc" => 0,
            "offset" => 0,
            "limit" => 1000
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/statistic', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->groupChatStatistic(1600272000,
            ['zhangsan'],[
            "day_end_time" => 1600444800,
            "order_by" => 2,
            "order_asc" => 0,
            "offset" => 0,
            "limit" => 1000
        ]));
    }

    /**
     * 获取「群聊数据统计」数据. (按自然日聚合的方式)
     * @return void
     */
    public function testGroupChatStatisticGroupByDay()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "day_begin_time" => 1600272000,
            "day_end_time" => 1600444800,
            "owner_filter" => [
                "userid_list" => [
                    "zhangsan"
                ]
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/statistic_group_by_day', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->groupChatStatisticGroupByDay(
            1600272000,1600444800,['zhangsan']
        ));
    }
}