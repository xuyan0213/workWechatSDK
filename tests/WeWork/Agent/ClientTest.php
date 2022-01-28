<?php


namespace WorkWechatSdk\Tests\WeWork\Agent;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\Agent\Client;

class ClientTest extends TestCase
{
    /**
     * 测试获取指定的应用详情
     * @return void
     */
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'agentid' => '100001'
        ];
        $client->expects()->httpGet('cgi-bin/agent/get', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->get(100001));
    }

    /**
     * 设置应用
     * @return void
     */
    public function testSet()
    {
        $client = $this->mockApiClient(Client::class);
        $agentId = ['agentid' => 100001];
        $params = [
            "report_location_flag" => 0,
            "logo_mediaid" => "j5Y8X5yocspvBHcgXMSS6z1Cn9RQKREEJr4ecgLHi4YHOYP-plvom-yD9zNI0vEl",
            "name" => "财经助手",
            "description" => "内部财经服务平台",
            "redirect_domain" => "open.work.weixin.qq.com",
            "isreportenter" => 0,
            "home_url" => "https://open.work.weixin.qq.com"
        ];
        $client->expects()->httpPostJson('cgi-bin/agent/set', array_merge($agentId, $params))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->set(100001, $params));
    }

    /**
     * 创建自定义菜单
     * @return void
     */
    public function testCreateMenu()
    {
        $client = $this->mockApiClient(Client::class);
        $agentId = ['agentid' => 100001];
        $params = [
            'button' => [
                [
                    'name' => '今日歌曲',
                    'type' => 'click',
                    'key' => 'V1001_TODAY_MUSIC'
                ],
                [
                    'name' => '菜单',
                    'sub_button' => [
                        [
                            'name' => '搜索',
                            'type' => 'view',
                            'url' => 'https://www.soso.com'
                        ],
                        [
                            'name' => '赞一下',
                            'type' => 'click',
                            'key' => 'V1001_GOOD'
                        ]
                    ]
                ]
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/menu/create', array_merge($agentId, $params))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->createMenu(100001, $params));
    }

    /**
     * 获取菜单
     * @return void
     */
    public function testGetMenu()
    {
        $client = $this->mockApiClient(Client::class);
        $params = ['agentid'=>100001];
        $client->expects()->httpGet('cgi-bin/menu/get', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getMenu(100001));
    }

    /**
     * 删除菜单
     * @return void
     */
    public function testDeleteMenu()
    {
        $client = $this->mockApiClient(Client::class);
        $params = ['agentid'=>100001];
        $client->expects()->httpGet('cgi-bin/menu/delete', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->deleteMenu(100001));
    }

    /**
     * 获取应用列表
     * @return void
     */
    public function testList()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('cgi-bin/agent/list')->andReturn('mock-result');
        $this->assertSame('mock-result', $client->list());
    }
}