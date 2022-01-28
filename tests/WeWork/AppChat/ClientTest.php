<?php

namespace WorkWechatSdk\Tests\WeWork\AppChat;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\AppChat\Client;

/**
 * 群聊会话测试
 */
class ClientTest extends TestCase
{

    /**
     * 创建群聊会话
     * @return void
     */
    public function testCreate()
    {
        $params = [
            [
                "name" => "NAME",
                "owner" => "userid1",
                "userlist" => ["userid1", "userid2", "userid3"],
                "chatid" => "CHATID"
            ]
        ];
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('cgi-bin/appchat/create', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->create($params));
    }

    /**
     * 更新群聊会话
     * @return void
     */
    public function testUpdate()
    {
        $chatId = ["chatid" => "CHATID"];
        $params = [
            [
                "name" => "NAME",
                "owner" => "userid1",
                "add_user_list" => ["userid1", "userid2", "userid3"],
                "del_user_list" => ["userid3", "userid4"]
            ]
        ];
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('cgi-bin/appchat/update', array_merge($chatId, $params))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->update('CHATID', $params));
    }

    /**
     * 获取群聊会话
     * @return void
     */
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('cgi-bin/appchat/get', ['chatid' => 'test001'])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->get('test001'));
    }

    /**
     * 应用推送消息
     * @return void
     */
    public function testSend()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "chatid" => "CHATID",
            "msgtype" => "text",
            "text" => [
                "content" => "你的快递已到\n请携带工卡前往邮件中心领取"
            ],
            "safe" => 0
        ];
        $client->expects()->httpPostJson('cgi-bin/appchat/send', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->send($params));
    }
}