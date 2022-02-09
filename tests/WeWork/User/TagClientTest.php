<?php


namespace WorkWechatSdk\Tests\WeWork\User;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\User\TagClient as Client;

/**
 * 标签管理
 */
class TagClientTest extends TestCase
{
    /**
     * 创建标签
     * @return void
     */
    public function testCreate()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'tagname' => '标签',
            'tagid' => null,
        ];
        $client->expects()->httpPostJson('cgi-bin/tag/create', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->create('标签'));

        $params = [
            'tagname' => '标签',
            'tagid' => 123,
        ];
        $client->expects()->httpPostJson('cgi-bin/tag/create', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->create('标签',123));
    }

    /**
     * 更新标签名字
     * @return void
     */
    public function testUpdate()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'tagid' => 123,
            'tagname' => '标签'
        ];
        $client->expects()->httpPostJson('cgi-bin/tag/update', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->update(123,'标签'));
    }

    /**
     * 删除标签
     * @return void
     */
    public function testDelete()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'tagid' => 123,
        ];
        $client->expects()->httpGet('cgi-bin/tag/delete', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->delete(123));
    }

    /**
     * 获取标签成员
     * @return void
     */
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'tagid' => 123,
        ];
        $client->expects()->httpGet('cgi-bin/tag/get', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->get(123));
    }

    /**
     * 增加标签成员
     * @return void
     */
    public function testTagUsers()
    {
        $client = $this->mockApiClient(Client::class);
        $client->allows('tagOrUntagUsers')->andReturn('mock-result');
        $params =[
            'tagid' => 123,
            'userlist' => ['aaa'],
            'partylist' => [],
        ];
        $client->expects()->httpPostJson('cgi-bin/tag/addtagusers', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->tagUsers(123,['aaa']));

        $params =[
            'tagid' => 123,
            'userlist' => [],
            'partylist' => [123],
        ];
        $client->expects()->httpPostJson('cgi-bin/tag/addtagusers', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->tagDepartments(123,[123]));
    }

    /**
     * 删除标签成员
     * @return void
     */
    public function testUntagUsers()
    {
        $client = $this->mockApiClient(Client::class);
        $client->allows('tagOrUntagUsers')->andReturn('mock-result');
        $params =[
            'tagid' => 123,
            'userlist' => ['aaa'],
            'partylist' => [],
        ];
        $client->expects()->httpPostJson('cgi-bin/tag/deltagusers', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->untagUsers(123,['aaa']));

        $params =[
            'tagid' => 123,
            'userlist' => [],
            'partylist' => [123],
        ];
        $client->expects()->httpPostJson('cgi-bin/tag/deltagusers', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->untagDepartments(123,[123]));
    }

    /**
     * 获取标签列表
     * @return void
     */
    public function testList()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpGet('cgi-bin/tag/list' )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->list(123,['aaa']));
    }

}