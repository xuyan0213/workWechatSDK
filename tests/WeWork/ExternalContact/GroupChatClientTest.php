<?php

namespace WorkWechatSdk\Tests\WeWork\ExternalContact;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\ExternalContact\GroupChatClient as Client;

/**
 * 客户联系-客户群
 */
class GroupChatClientTest extends TestCase
{

    /**
     * 获取客户群列表.
     * @return void
     */
    public function testGetGroupChats()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'status_filter' => 0,
            'owner_filter' => [
                'userid_list' => ['aaa']
            ],
            'cursor' => '',
            'limit' => 100
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/list', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getGroupChats(0, ['aaa'], '', 100));
    }

    /**
     * 获取客户群详情
     * @return void
     */
    public function testGetGroupChat()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'chat_id' => 'aaa',
            'need_name' => 0,
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/get', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getGroupChat('aaa', 0));
    }

    /**
     * 客户群opengid转换
     * @return void
     */
    public function testOpengidToChatid()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'opengid' => 'qwe',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/get', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->opengidToChatid('qwe'));
    }

    /**
     * 配置客户群进群方式
     * @return void
     */
    public function testAddJoinWay()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'scene' => 2,
            'chat_id_list' => ['aaa', 'bbb'],
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/add_join_way', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->addJoinWay(2,['aaa', 'bbb'],[]));
        $fields = [
            "remark" => "aa_remark",
            "auto_create_room" => 1,
            "room_base_name" => "销售客服群",
            "room_base_id" => 10,
            "state" => "klsdup3kj3s1"
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/add_join_way', array_merge($params, $fields))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->addJoinWay(2,['aaa', 'bbb'],$fields));
    }

    /**
     * 获取客户群进群方式配置
     * @return void
     */
    public function testGetJoinWay()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'config_id' => 'qwe',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/get_join_way', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getJoinWay('qwe'));
    }

    /**
     * 更新客户群进群方式配置
     * @return void
     */
    public function testUpdateJoinWay()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'config_id' => 'qwe',
            'scene' => 2,
            'chat_id_list' => ['aa','bb']
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/update_join_way', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->updateJoinWay('qwe', 2,['aa','bb'],[]));
        $fields = [
            "remark" => "aa_remark",
            "auto_create_room" => 1,
            "room_base_name" => "销售客服群",
            "room_base_id" => 10,
            "state" => "klsdup3kj3s1"
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/update_join_way', array_merge($params,$fields))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->updateJoinWay('qwe', 2,['aa','bb'],$fields));
    }

    /**
     * 删除客户群进群方式配置
     * @return void
     */
    public function testDelJoinWay()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'config_id' => 'qwe',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/del_join_way', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->delJoinWay('qwe'));
    }
}