<?php

namespace WorkWechatSdk\Tests\WeWork\Base;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\Base\Client;

class ClientTest extends TestCase
{

    /**
     * 获取企业微信服务器的ip段
     * @return void
     */
    public function testGetCallbackIp()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('cgi-bin/getcallbackip')->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getCallbackIp());
    }

    /**
     * 将明文corpid转换为第三方应用获取的corpid
     * @return void
     */
    public function testGetOpenCorpid()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'corpid' => 'wx123456'
        ];
        $client->expects()->httpPostJson('cgi-bin/corp/to_open_corpid',$params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getOpenCorpid('wx123456'));
    }

    /**
     * 将自建应用获取的userid转换为第三方应用获取的userid
     * @return void
     */
    public function testBatchUseridToOpenUserid()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "userid_list"=>["aaa", "bbb"]
        ];
        $client->expects()->httpPostJson('cgi-bin/batch/userid_to_openuserid',$params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->batchUseridToOpenUserid(["aaa", "bbb"]));
    }

    /**
     * 将自建应用获取的userid转换为第三方应用获取的userid
     * @return void
     */
    public function testGetUser()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'code' => 'aaa',
        ];
        $client->expects()->httpGet('cgi-bin/user/getuserinfo',$params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getUser('aaa'));
    }
}