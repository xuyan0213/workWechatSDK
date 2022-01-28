<?php

namespace WorkWechatSdk\Tests\WeWork\ExternalContact;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\ExternalContact\Client;

/**
 * 客户联系-客户管理
 */
class ClientTest extends TestCase
{

    /**
     * 获取外部联系人列表.
     * @return void
     */
    public function testList()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'userid' => 'aaa',
        ];
        $client->expects()->httpGet('cgi-bin/externalcontact/list', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->list('aaa'));
    }

    /**
     * 获取外部联系人详情.
     * @return void
     */
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'external_userid' => 'ww123',
        ];
        $client->expects()->httpGet('cgi-bin/externalcontact/get', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->get('ww123'));
    }

    /**
     * 获取外部联系人详情.
     * @return void
     */
    public function testBatchGetByUser()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'userid_list' => ['aaa', 'bbb'],
            'cursor' => '',
            'limit' => 100,
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/batch/get_by_user', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->batchGetByUser(['aaa', 'bbb'], '', 100));
    }

    /**
     * 修改客户备注信息.
     * @return void
     */
    public function testRemark()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'userid' => 'aaa',
            'external_userid' => 'ww123'
        ];
        $data = [
            "remark" => "备注信息",
            "description" => "描述信息",
            "remark_company" => "腾讯科技",
            "remark_mobiles" => [
                "13800000001",
                "13800000002"
            ],
            "remark_pic_mediaid" => "MEDIAID"
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/remark', array_merge($params,$data))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->remark('aaa', 'ww123', $data));
    }
}