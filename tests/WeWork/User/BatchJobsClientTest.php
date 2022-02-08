<?php


namespace WorkWechatSdk\Tests\WeWork\User;

use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\User\BatchJobsClient as Client;

/**
 * 异步批量接口
 */
class BatchJobsClientTest extends TestCase
{
    /**
     * 增量更新成员
     * @return void
     */
    public function testBatchUpdateUsers()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "media_id" => "qwe",
            "to_invite" => true,
            "callback" => [
                "url" => "qwe",
                "token" => "qwe",
                "encodingaeskey" => "qwe"
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/batch/syncuser', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->batchUpdateUsers('qwe',true,[
            "url" => "qwe",
            "token" => "qwe",
            "encodingaeskey" => "qwe"
        ]));
    }

    /**
     * 全量覆盖成员
     * @return void
     */
    public function testBatchReplaceUsers()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "media_id" => "qwe",
            "to_invite" => true,
            "callback" => [
                "url" => "qwe",
                "token" => "qwe",
                "encodingaeskey" => "qwe"
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/batch/replaceuser', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->batchReplaceUsers('qwe',true,[
            "url" => "qwe",
            "token" => "qwe",
            "encodingaeskey" => "qwe"
        ]));
    }

    /**
     * 更新成员
     * @return void
     */
    public function testBatchReplaceDepartments()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "media_id" => "qwe",
            "to_invite" => true,
            "callback" => [
                "url" => "qwe",
                "token" => "qwe",
                "encodingaeskey" => "qwe"
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/batch/replaceparty', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->batchReplaceDepartments('qwe',true,[
            "url" => "qwe",
            "token" => "qwe",
            "encodingaeskey" => "qwe"
        ]));
    }

    /**
     * 删除成员
     * @return void
     */
    public function testGetJobStatus()
    {
        $client = $this->mockApiClient(Client::class, 'batchDelete');
        $params = [
            'jobid' => 'qwe'
        ];
        $client->expects()->httpGet('cgi-bin/batch/getresult', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getJobStatus('qwe'));
    }
}