<?php

namespace WorkWechatSdk\Tests\WeWork\Message;


use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\Message\Client;
use WorkWechatSdk\WeWork\Message\Messenger;


/**
 * 消息推送
 */
class ClientTest extends TestCase
{

    /**
     * @return void
     */
    public function testMessage()
    {
        $client = $this->mockApiClient(Client::class);

        $this->assertInstanceOf(Messenger::class, $client->message('hello'));
    }

    /**
     * 推送消息
     * @return void
     */
    public function testSend()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('cgi-bin/message/send', ['foo' => 'bar'])->andReturn('mock-result');

        $this->assertSame('mock-result', $client->send(['foo' => 'bar']));
    }

    /**
     * 更新任务卡片消息状态
     * @return void
     */
    public function testUpdateTaskCard()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'userids' => ['userid1','userid2'],
            'agentid' => 1,
            'task_id' => 'taskid1',
            'replace_name' => '已收到'
        ];

        $client->expects()->httpPostJson('cgi-bin/message/update_taskcard', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->updateTaskcard(['userid1','userid2'], 1, 'taskid1', '已收到'));
    }
}