<?php

namespace WorkWechatSdk\Tests\WeWork\MsgAudit;


use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\MsgAudit\Client;


/**
 * 会话内容存档
 */
class ClientTest extends TestCase
{

    /**
     * 获取会话内容存档开启成员列表
     * @return void
     */
    public function testGetPermitUsers()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('cgi-bin/msgaudit/get_permit_user_list', [])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getPermitUsers());
    }


    /**
     * 获取会话同意情况(单聊)
     * @return void
     */
    public function testGetSingleAgreeStatus()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'info' => [[
                'userid' => 'aaa',
                'exteranalopenid' => 'ww1'
            ],
                [
                    'userid' => 'bbb',
                    'exteranalopenid' => 'ww2'
                ],
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/msgaudit/check_single_agree', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getSingleAgreeStatus([[
            'userid' => 'aaa',
            'exteranalopenid' => 'ww1'
        ],
            [
                'userid' => 'bbb',
                'exteranalopenid' => 'ww2'
            ],
        ]));
    }

    /**
     * 获取会话同意情况(群聊)
     * @return void
     */
    public function testGetRoomAgreeStatus()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'roomid' => 'qwe'
        ];

        $client->expects()->httpPostJson('cgi-bin/msgaudit/check_room_agree', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getRoomAgreeStatus('qwe'));
    }

    /**
     * 获取会话内容存档内部群信息
     * @return void
     */
    public function testGetRoom()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'roomid' => 'qwe'
        ];

        $client->expects()->httpPostJson('cgi-bin/msgaudit/groupchat/get', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getRoom('qwe'));
    }
}