<?php


namespace WorkWechatSdk\Tests\WeWork\Agent;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\Agent\WorkbenchClient;

/**
 * 企业微信应用工作台.
 */
class WorkbenchClientTest extends TestCase
{
    /**
     * 测试设置工作台自定义展示
     * @return void
     */
    public function testSetWorkbenchTemplate()
    {
        $client = $this->mockApiClient(WorkbenchClient::class);
        $params = [
            'agentid' => 100001,
        ];
        $attributes = [
            "type" => "image",
            "image" => [
                "url" => "xxxx",
                "jump_url" => "http://www.qq.com",
                "pagepath" => "pages/index"
            ],
            "replace_user_data" => true
        ];

        $client->expects()->httpPostJson('cgi-bin/agent/set_workbench_template', array_merge($params, $attributes))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->setWorkbenchTemplate(100001,$attributes));
    }

    /**
     * 获取应用在工作台展示的模版
     * @return void
     */
    public function testGetWorkbenchTemplate()
    {
        $client = $this->mockApiClient(WorkbenchClient::class);
        $agentId = ['agentid' => 100001];

        $client->expects()->httpGet('cgi-bin/agent/get_workbench_template', $agentId)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getWorkbenchTemplate(100001));
    }

    /**
     * 设置应用在用户工作台展示的数据
     * @return void
     */
    public function testSetWorkbenchData()
    {
        $client = $this->mockApiClient(WorkbenchClient::class);
        $agentId = ['agentid' => 100001];
        $params = [
            "userid" => "test",
            "type" => "keydata",
            "keydata" => [
                "items" => [
                    [
                        "key" => "待审批",
                        "data" => "2",
                        "jump_url" => "https://www.qq.com",
                        "pagepath" => "pages/index"
                    ],
                    [
                        "key" => "带批阅作业",
                        "data" => "4",
                        "jump_url" => "https://www.qq.com",
                        "pagepath" => "pages/index"
                    ],
                    [
                        "key" => "成绩录入",
                        "data" => "45",
                        "jump_url" => "https://www.qq.com",
                        "pagepath" => "pages/index"
                    ],
                    [
                        "key" => "综合评价",
                        "data" => "98",
                        "jump_url" => "https://www.qq.com",
                        "pagepath" => "pages/index"
                    ]
                ]
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/agent/set_workbench_data', array_merge($agentId, $params))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->setWorkbenchData(100001, $params));
    }
}