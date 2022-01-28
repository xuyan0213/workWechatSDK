<?php

namespace WorkWechatSdk\Tests\WeWork\ExternalContact;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\ExternalContact\ContactWayClient as Client;

/**
 * 客户联系-企业服务人员管理
 */
class ContactWayClientTest extends TestCase
{

    /**
     * 获取配置了客户联系功能的成员列表.
     * @return void
     */
    public function testGetFollowUsers()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('cgi-bin/externalcontact/get_follow_user_list')->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getFollowUsers());
    }

    /**
     * 配置客户联系「联系我」方式.
     * @return void
     */
    public function testCreate()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'type' => 1,
            'scene' => 2,
        ];
        $config = [
            "style" => 1,
            "remark" => "渠道客户",
            "skip_verify" => true,
            "state" => "teststate",
            "user" => ["zhangsan", "lisi", "wangwu"],
            "party" => [2, 3],
            "is_temp" => true,
            "expires_in" => 86400,
            "chat_expires_in" => 86400,
            "unionid" => "oxTWIuGaIt6gTKsQRLau2M0AAAA",
            "conclusions" =>
                [
                    "text" =>
                        [
                            "content" => "文本消息内容"
                        ],
                    "image" =>
                        [
                            "media_id" => "MEDIA_ID"
                        ],
                    "link" =>
                        [
                            "title" => "消息标题",
                            "picurl" => "https://example.pic.com/path",
                            "desc" => "消息描述",
                            "url" => "https://example.link.com/path"
                        ],
                    "miniprogram" =>
                        [
                            "title" => "消息标题",
                            "pic_media_id" => "MEDIA_ID",
                            "appid" => "wx8bd80126147dfAAA",
                            "page" => "/path/index.html"
                        ]
                ]
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/add_contact_way', array_merge($params,$config))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->create(1,2,$config));
    }

    /**
     * 获取企业已配置的「联系我」方式
     * @return void
     */
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'config_id' => 'qwe',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_contact_way', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->get('qwe'));
    }

    /**
     * 更新企业已配置的「联系我」方式.
     * @return void
     */
    public function testUpdate()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'config_id' => 'qwe',
        ];
        $config = [
            "style" => 1,
            "remark" => "渠道客户",
            "skip_verify" => true,
            "state" => "teststate",
            "user" => ["zhangsan", "lisi", "wangwu"],
            "party" => [2, 3],
            "is_temp" => true,
            "expires_in" => 86400,
            "chat_expires_in" => 86400,
            "unionid" => "oxTWIuGaIt6gTKsQRLau2M0AAAA",
            "conclusions" =>
                [
                    "text" =>
                        [
                            "content" => "文本消息内容"
                        ],
                    "image" =>
                        [
                            "media_id" => "MEDIA_ID"
                        ],
                    "link" =>
                        [
                            "title" => "消息标题",
                            "picurl" => "https://example.pic.com/path",
                            "desc" => "消息描述",
                            "url" => "https://example.link.com/path"
                        ],
                    "miniprogram" =>
                        [
                            "title" => "消息标题",
                            "pic_media_id" => "MEDIA_ID",
                            "appid" => "wx8bd80126147dfAAA",
                            "page" => "/path/index.html"
                        ]
                ]
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/update_contact_way', array_merge($params, $config))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->update('qwe', $config));
    }

    /**
     * 删除企业已配置的「联系我」方式
     * @return void
     */
    public function testDelete()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'config_id' => 'qwe',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/del_contact_way', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->delete('qwe'));
    }

    /**
     * 获取企业已配置的「联系我」列表
     * @return void
     */
    public function testList()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'cursor' => '',
            'limit' => 100,
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/list_contact_way', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->list('',100));
    }
}