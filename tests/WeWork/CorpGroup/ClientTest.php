<?php

namespace WorkWechatSdk\Tests\WeWork\CorpGroup;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\CorpGroup\Client;

/**
 * 企业互联
 */
class ClientTest extends TestCase
{

    /**
     * 获取应用共享信息.
     * @return void
     */
    public function testGetAppShareInfo()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'agentid' => 100001
        ];
        $client->expects()->httpPostJson('cgi-bin/corpgroup/corp/list_app_share_info',$params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getAppShareInfo(100001));
    }

    /**
     * 获取下级企业的access_token.
     * @return void
     */
    public function testGetToken()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'corpid' => 'wx123456',
            'agentid' => 100001
        ];
        $client->expects()->httpPostJson('cgi-bin/corpgroup/corp/gettoken',$params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getToken('wx123456',100001));
    }

    /**
     * 获取下级企业的小程序session.
     * @return void
     */
    public function testGetMiniProgramTransferSession()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'userid' => 'aaa',
            'session_key' => 'key'
        ];
        $client->expects()->httpPostJson('cgi-bin/miniprogram/transfer_session',$params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getMiniProgramTransferSession("aaa", "key"));
    }
}