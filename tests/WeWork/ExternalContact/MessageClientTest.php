<?php

namespace WorkWechatSdk\Tests\WeWork\ExternalContact;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\ExternalContact\MessageClient as Client;

/**
 * 客户联系-客户群
 */
class MessageClientTest extends TestCase
{

    /**
     * 添加企业群发消息模板
     * @return void
     */
    public function testAddMsgTemplate()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'chat_type' => 'group',
            'external_userid' => [
                'mock-userid-1',
                'mock-userid-2',
            ],
            'sender' => 'zhangsan',
            'text' => [
                'content' => 'mock-content',
            ],
            'attachments' => [
                [
                    "msgtype" => "image",
                    'image' => [
                        'media_id' => 'mock-media_id',
                        'pic_url'=> 'mock-pic_url'
                    ],
                ],
                [
                    "msgtype" => "link",
                    'link' => [
                        'title' => 'mock-title',
                        'picurl' => 'mock-picurl',
                        'desc' => 'mock-desc',
                        'url' => 'mock-url',
                    ],
                ],
                [
                    "msgtype" => "miniprogram",
                    'miniprogram' => [
                        'title' => 'mock-title',
                        'pic_media_id' => 'mock-pic_media_id',
                        'appid' => 'mock-appid',
                        'page' => 'mock-page',
                    ]
                ],
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/add_msg_template', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->addMsgTemplate('group', [
            'mock-userid-1',
            'mock-userid-2',
        ], 'zhangsan', 'mock-content', [
            'image' => [
                'media_id' => 'mock-media_id',
                "pic_url" => 'mock-pic_url'
            ],
            'link' => [
                'title' => 'mock-title',
                'picurl' => 'mock-picurl',
                'desc' => 'mock-desc',
                'url' => 'mock-url',
            ],
            'miniprogram' => [
                'title' => 'mock-title',
                'pic_media_id' => 'mock-pic_media_id',
                'appid' => 'mock-appid',
                'page' => 'mock-page',
            ]]));
    }

    /**
     * 获取客户群详情
     * @return void
     */
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'msgid' => 'qwe',
            'limit' => 10000,
            'cursor' => ''
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_group_msg_result', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->get('qwe', 10000,''));
    }

    /**
     * 获取群发记录列表
     * @return void
     */
    public function testGetGroupmsgListV2()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'chat_type' => 'single',
            'start_time' => 123,
            'end_time' => 456,
            'creator' => 'aaa',
            'filter_type' => 2,
            'limit' => 1000,
            'cursor' => '',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_groupmsg_list_v2', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getGroupmsgListV2('single',
        123,456,'aaa',2,1000,''
        ));
    }

    /**
     * 获取群发成员发送任务列表
     * @return void
     */
    public function testGetGroupmsgTask()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'msgid' => 'qwe',
            'limit' => 1000,
            'cursor' => '',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_groupmsg_task', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getGroupmsgTask('qwe',1000,''));
    }

    /**
     * 获取企业群发成员执行结果
     * @return void
     */
    public function testGetGroupmsgSendResult()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'msgid' => 'qwe',
            'userid' => 'aaa',
            'limit' => 1000,
            'cursor' => '',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_groupmsg_send_result', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getGroupmsgSendResult('qwe','aaa',1000,''));
    }

    /**
     * 发送新客户欢迎语
     * @return void
     */
    public function testSendWelcome()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'welcome_code' => 'qwe',
            'text' => [
                'content' => 'mock-content'
            ],
            'attachments' => [
                [
                    "msgtype" => "image",
                    'image' => [
                        'media_id' => 'mock-media_id',
                        'pic_url'=> 'mock-pic_url'
                    ],
                ],
                [
                    "msgtype" => "link",
                    'link' => [
                        'title' => 'mock-title',
                        'picurl' => 'mock-picurl',
                        'desc' => 'mock-desc',
                        'url' => 'mock-url',
                    ],
                ],
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/send_welcome_msg', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->sendWelcome('qwe', 'mock-content', [
            'image' => [
                'media_id' => 'mock-media_id',
                "pic_url" => 'mock-pic_url'
            ],
            'link' => [
                'title' => 'mock-title',
                'picurl' => 'mock-picurl',
                'desc' => 'mock-desc',
                'url' => 'mock-url',
            ]
        ]));
    }

    /**
     * 添加入群欢迎语素材
     * @return void
     */
    public function testAddGroupWelcomeTemplate()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "text" => [
                "content" => "亲爱的%NICKNAME%用户，你好"
            ],
            "image" => [
                "media_id" => "MEDIA_ID",
                "pic_url" => "http://p.qpic.cn/pic_wework/3474110808/7a6344sdadfwehe42060/0"
            ],
            "link" => [
                "title" => "消息标题",
                "picurl" => "https://example.pic.com/path",
                "desc" => "消息描述",
                "url" => "https://example.link.com/path"
            ],
            "miniprogram" => [
                "title" => "消息标题",
                "pic_media_id" => "MEDIA_ID",
                "appid" => "wx8bd80126147dfAAA",
                "page" => "/path/index"
            ],
            "file" => [
                "media_id" => "1Yv-zXfHjSjU-7LH-GwtYqDGS-zz6w22KmWAT5COgP7o"
            ],
            "video" => [
                "media_id" => "MEDIA_ID"
            ],
            "agentid" => 1000014,
            "notify" => 1
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/group_welcome_template/add', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->addGroupWelcomeTemplate($params));
    }

    /**
     * 编辑入群欢迎语素材
     * @return void
     */
    public function testUpdateGroupWelcomeTemplate()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'template_id'=>'qwe',
            "text" => [
                "content" => "亲爱的%NICKNAME%用户，你好"
            ],
            "image" => [
                "media_id" => "MEDIA_ID",
                "pic_url" => "http://p.qpic.cn/pic_wework/3474110808/7a6344sdadfwehe42060/0"
            ],
            "link" => [
                "title" => "消息标题",
                "picurl" => "https://example.pic.com/path",
                "desc" => "消息描述",
                "url" => "https://example.link.com/path"
            ],
            "miniprogram" => [
                "title" => "消息标题",
                "pic_media_id" => "MEDIA_ID",
                "appid" => "wx8bd80126147dfAAA",
                "page" => "/path/index"
            ],
            "file" => [
                "media_id" => "1Yv-zXfHjSjU-7LH-GwtYqDGS-zz6w22KmWAT5COgP7o"
            ],
            "video" => [
                "media_id" => "MEDIA_ID"
            ],
            "agentid" => 1000014
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/group_welcome_template/edit', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->updateGroupWelcomeTemplate('qwe',$params));
    }

    /**
     * 获取入群欢迎语素材
     * @return void
     */
    public function testGetGroupWelcomeTemplate()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'template_id'=>'qwe',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/group_welcome_template/get', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getGroupWelcomeTemplate('qwe'));
    }

    /**
     * 删除入群欢迎语素材
     * @return void
     */
    public function testDeleteGroupWelcomeTemplate()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'template_id'=>'qwe',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/group_welcome_template/del', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->deleteGroupWelcomeTemplate('qwe'));
    }
}