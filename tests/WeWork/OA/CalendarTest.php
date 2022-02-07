<?php

namespace WorkWechatSdk\Tests\WeWork\OA;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\OA\CalendarClient as Client;


/**
 * 效率工具 日历模块
 */
class CalendarTest extends TestCase
{

    /**
     * 创建日历
     * @return void
     */
    public function testAdd()
    {
        $client = $this->mockApiClient(Client::class);
        $calendar = [
                "organizer" => "userid1",
                "readonly" => 1,
                "set_as_default" => 1,
                "summary" => "test_summary",
                "color" => "#FF3030",
                "description" => "test_describe",
                "shares" => [
                    [
                        "userid" => "userid2"
                    ],
                    [
                        "userid" => "userid3",
                        "readonly" => 1
                    ]
                ]
        ];
        $client->expects()->httpPostJson('cgi-bin/oa/calendar/add', compact('calendar'))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->add($calendar));
    }


    /**
     * 更新日历
     * @return void
     */
    public function testUpdate()
    {
        $client = $this->mockApiClient(Client::class);
        $calendar = [
            "readonly" => 1,
            "summary" => "test_summary",
            "color" => "#FF3030",
            "description" => "test_describe_1",
            "shares" => [
                [
                    "userid" => "userid1"
                ],
                [
                    "userid" => "userid2",
                    "readonly" => 1
                ]
            ]
        ];
        $calendar += ['cal_id' => 'wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA'];
        $client->expects()->httpPostJson('cgi-bin/oa/calendar/update', compact('calendar'))->andReturn('mock-result');

        $this->assertSame('mock-result', $client->update('wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA',$calendar));
    }

    /**
     * 获取日历详情
     * @return void
     */
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'cal_id_list' => [
                'wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA'
            ]
        ];

        $client->expects()->httpPostJson('cgi-bin/oa/calendar/get', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->get(['wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA']));
    }

    /**
     * 获取会话内容存档内部群信息
     * @return void
     */
    public function testDelete()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'cal_id' => 'wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA'
        ];

        $client->expects()->httpPostJson('cgi-bin/oa/calendar/del', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->delete('wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA'));
    }
}