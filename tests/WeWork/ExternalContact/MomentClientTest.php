<?php

namespace WorkWechatSdk\Tests\WeWork\ExternalContact;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\ExternalContact\MomentClient as Client;

/**
 * 客户联系-客户朋友圈
 */
class MomentClientTest extends TestCase
{

    /**
     * 创建发表任务
     * @return void
     */
    public function testCreateTask()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'visible_range' => [ //指定的发表范围
                'sender_list' => [
                    'user_list' => ['aaa','bbb'],
                    'department_list' => []
                ],
                'external_contact_list' => [
                    'tag_list' => []
                ]
            ],
            'text' => [
                'content' => '内容'
            ],
            'attachments' => [
                [
                    "msgtype" => "image",
                    'image' => [
                        'media_id' => 'mock-media_id'
                    ],
                ],
                [
                    "msgtype" => "link",
                    'link' => [
                        'title' => 'mock-title',
                        'media_id' => 'mock-media_id',
                        'url' => 'mock-url',
                    ],
                ]
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/add_moment_task', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->createTask([
            'aaa',
            'bbb',
        ], [], [],'内容', [
            'image' => [
                'media_id' => 'mock-media_id',
            ],
            'link' => [
                'title' => 'mock-title',
                'media_id' => 'mock-media_id',
                'url' => 'mock-url',
            ]
        ]));
    }

    /**
     * 获取任务创建结果
     * @return void
     */
    public function testGetTask()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'jobid' => 'qwe'
        ];
        $client->expects()->httpGet('cgi-bin/externalcontact/get_moment_task_result', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getTask('qwe'));
    }

    /**
     * 获取企业全部的发表列表
     * @return void
     */
    public function testGetGroupmsgListV2()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'start_time' => 123,
            'end_time' => 456,
            'creator' => 'aaa',
            'filter_type' => 2,
            'limit' => 1000,
            'cursor' => '',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_moment_list', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->list(
        123,456,'aaa',2,'',1000
        ));
    }

    /**
     * 获取客户朋友圈企业发表的列表
     * @return void
     */
    public function testGetTasks()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'moment_id' => 'qwe',
            'limit' => 1000,
            'cursor' => '',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_moment_task', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getTasks('qwe','',1000));
    }

    /**
     * 获取客户朋友圈发表时选择的可见范围
     * @return void
     */
    public function testGetCustomers()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'moment_id' => 'qwe',
            'userid' => 'aaa',
            'limit' => 1000,
            'cursor' => '',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_moment_customer_list', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getCustomers('qwe','aaa','',1000));
    }

    /**
     * 获取客户朋友圈发表后的可见客户列表
     * @return void
     */
    public function testGetSendResult()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'moment_id' => 'qwe',
            'userid' => 'aaa',
            'cursor' => '',
            'limit' => 1000
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_moment_send_result', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getSendResult('qwe', 'aaa','',1000));
    }

    /**
     * 获取客户朋友圈的互动数据
     * @return void
     */
    public function testGetComments()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'moment_id' => 'qwe',
            'userid' => 'aaa'
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_moment_comments', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getComments('qwe','aaa'));
    }
}