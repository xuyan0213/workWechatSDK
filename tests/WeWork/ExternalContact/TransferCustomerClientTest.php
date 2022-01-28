<?php

namespace WorkWechatSdk\Tests\WeWork\ExternalContact;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\ExternalContact\TransferCustomerClient as Client;

/**
 * 客户联系-在职/离职继承
 */
class TransferCustomerClientTest extends TestCase
{

    /**
     * 获取离职成员的客户列表
     * @return void
     */
    public function testGetUnassigned()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'page_id' => 0,
            'page_size' => 1000,
            'cursor' => '',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_unassigned_list', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getUnassigned(0,1000,''));
    }

    /**
     * 分配离职成员的客户
     * @return void
     */
    public function testResignedTransferCustomer()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'external_userid' => ['ww123'],
            'handover_userid' => 'aaa',
            'takeover_userid' => 'bbb',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/resigned/transfer_customer', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->resignedTransferCustomer(
            ['ww123'],'aaa','bbb'
        ));
    }

    /**
     * 分配离职成员的客户群
     * @return void
     */
    public function testTransferGroupChat()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'chat_id_list' => ['wer'],
            'new_owner' => 'aaa'
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/groupchat/transfer', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->transferGroupChat(
            ['wer'],'aaa'
        ));
    }

    /**
     * 离职继承查询客户接替状态
     * @return void
     */
    public function testResignedTransferResult()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'handover_userid' => 'aaa',
            'takeover_userid' => 'bbb',
            'cursor' => '',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/resigned/transfer_result', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->resignedTransferResult(
            'aaa','bbb',''
        ));
    }

    /**
     * 在职继承查询客户接替状态
     * @return void
     */
    public function testTransferResult()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'handover_userid' => 'aaa',
            'takeover_userid' => 'bbb',
            'cursor' => '',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/transfer_result', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->transferResult(
            'aaa','bbb',''
        ));
    }

    /**
     * 分配在职成员的客户
     * @return void
     */
    public function testTransferCustomer()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'external_userid' => ['qwe','wer'],
            'handover_userid' => 'aaa',
            'takeover_userid' => 'bbb',
            'transfer_success_msg' => 'msg'
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/transfer_customer', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->transferCustomer(
            ['qwe','wer'],'aaa','bbb','msg'
        ));
    }

    /**
     * 分配在职成员的客户
     * @return void
     * @deprecated 接口已停止维护
     */
    public function testTransfer()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'external_userid' => 'qwe',
            'handover_userid' => 'aaa',
            'takeover_userid' => 'bbb',
            'transfer_success_msg' => 'msg'
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/transfer', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->transfer(
            'qwe','aaa','bbb','msg'
        ));
    }

    /**
     * 查询客户接替结果
     * @return void
     * @deprecated 接口已停止维护
     */
    public function testGetTransferResult()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'external_userid' => 'qwe',
            'handover_userid' => 'aaa',
            'takeover_userid' => 'bbb',
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_transfer_result', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getTransferResult(
            'qwe','aaa','bbb'
        ));
    }

}