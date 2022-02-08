<?php


namespace WorkWechatSdk\Tests\WeWork\User;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\User\DepartmentClient as Client;

/**
 * 部门管理
 */
class DepartmentClientTest extends TestCase
{
    /**
     * 创建部门
     * @return void
     */
    public function testBatchUpdateUsers()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "name" => "上海研发中心",
            "name_en" => null,
            "parentid" => 1,
            "order" => null,
            "id" => null
        ];
        $client->expects()->httpPostJson('cgi-bin/department/create', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->create('上海研发中心',1));

        $params = [
            "name" => "广州研发中心",
            "name_en" => 'GZYF',
            "parentid" => 1,
            "order" => 2,
            "id" => 3
        ];
        $client->expects()->httpPostJson('cgi-bin/department/create', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->create('广州研发中心',1,'GZYF',2,3));
    }

    /**
     * 更新部门
     * @return void
     */
    public function testUpdate()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "name" => "上海研发中心",
            "name_en" => null,
            "parentid" => 1,
            "order" => null,
            "id" => 1
        ];
        $client->expects()->httpPostJson('cgi-bin/department/update', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->update(1,'上海研发中心',1));
    }

    /**
     * 删除部门
     * @return void
     */
    public function testDelete()
    {
        $client = $this->mockApiClient(Client::class);
        $id = 123;
        $client->expects()->httpGet('cgi-bin/department/delete', compact('id'))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->delete(123));
    }

    /**
     * 获取子部门ID列表
     * @return void
     */
    public function testSimpleList()
    {
        $client = $this->mockApiClient(Client::class);
        $id = 123;
        $client->expects()->httpGet('cgi-bin/department/simplelist', compact('id'))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->simpleList(123));
    }

    /**
     * 获取单个部门详情
     * @return void
     */
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $id = 123;
        $client->expects()->httpGet('cgi-bin/department/get', compact('id'))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->get(123));
    }

    /**
     * 获取部门列表
     * @return void
     */
    public function testList()
    {
        $client = $this->mockApiClient(Client::class);
        $id = 123;
        $client->expects()->httpGet('cgi-bin/department/list', compact('id'))->andReturn('mock-result');
        $this->assertSame('mock-result', $client->list(123));
    }
}