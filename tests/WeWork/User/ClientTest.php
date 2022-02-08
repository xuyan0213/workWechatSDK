<?php


namespace WorkWechatSdk\Tests\WeWork\User;

use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\User\Client;

/**
 * 成员管理
 */
class ClientTest extends TestCase
{
    /**
     * 创建成员
     * @return void
     */
    public function testCreate()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('cgi-bin/user/create', ['foo' => 'bar'])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->create(['foo' => 'bar']));
    }

    /**
     * 读取成员
     * @return void
     */
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('cgi-bin/user/get', ['userid' => 'overtrue'])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->get('overtrue'));
    }

    /**
     * 更新成员
     * @return void
     */
    public function testUpdate()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('cgi-bin/user/update', ['userid' => 'overtrue', 'foo' => 'bar'])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->update('overtrue', ['foo' => 'bar']));
    }

    /**
     * 删除成员
     * @return void
     */
    public function testDelete()
    {
        $client = $this->mockApiClient(Client::class, 'batchDelete');
        $client->expects()->httpGet('cgi-bin/user/delete', ['userid' => 'overtrue'])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->delete('overtrue'));

        $client->expects()->batchDelete(['overtrue', 'foo'])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->delete(['overtrue', 'foo']));
    }

    /**
     * 批量删除成员
     * @return void
     */
    public function testBatchDelete()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('cgi-bin/user/batchdelete', ['useridlist' => ['overtrue', 'foo']])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->batchDelete(['overtrue', 'foo']));
    }

    /**
     * 获取部门成员
     * @return void
     */
    public function testGetDepartmentUsers()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('cgi-bin/user/simplelist', [
            'department_id' => 14,
            'fetch_child' => 0,
        ])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getDepartmentUsers(14));

        $client->expects()->httpGet('cgi-bin/user/simplelist', [
            'department_id' => 15,
            'fetch_child' => 1,
        ])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getDepartmentUsers(15, true));
    }

    /**
     * 获取部门成员详情
     * @return void
     */
    public function testGetDetailedDepartmentUsers()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('cgi-bin/user/list', [
            'department_id' => 18,
            'fetch_child' => 0,
        ])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getDetailedDepartmentUsers(18));

        $client->expects()->httpGet('cgi-bin/user/list', [
            'department_id' => 18,
            'fetch_child' => 1,
        ])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getDetailedDepartmentUsers(18, true));
    }

    /**
     * userid与openid互换 userid转openid
     * @return void
     */
    public function testUserIdToOpenid()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('cgi-bin/user/convert_to_openid', ['userid' => 'overtrue'])
            ->andReturn('mock-result');
        $this->assertSame('mock-result', $client->userIdToOpenid('overtrue'));
    }

    /**
     * userid与openid互换.openid转userid
     * @return void
     */
    public function testOpenidToUserId()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('cgi-bin/user/convert_to_userid', ['openid' => 'mock-openid'])
            ->andReturn('mock-result');
        $this->assertSame('mock-result', $client->openidToUserId('mock-openid'));
    }

    /**
     * 手机号获取userid
     * @return void
     */
    public function testMobileToUserId()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpPostJson('cgi-bin/user/getuserid', ['mobile' => 'mock-mobile'])
            ->andReturn('mock-result');
        $this->assertSame('mock-result', $client->mobileToUserId('mock-mobile'));
    }

    /**
     * 二次验证
     * @return void
     */
    public function testAccept()
    {
        $client = $this->mockApiClient(Client::class);
        $client->expects()->httpGet('cgi-bin/user/authsucc', ['userid' => 'overtrue'])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->accept('overtrue'));
    }

    /**
     * 邀请成员
     * @return void
     */
    public function testInvite()
    {
        $client = $this->mockApiClient(Client::class);
        $params = ['user' => ['mock-user-id']];
        $client->expects()->httpPostJson('cgi-bin/batch/invite', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->invite($params));
    }

    /**
     * 获取加入企业二维码
     * @return void
     */
    public function testGetInvitationQrCode()
    {
        $client = $this->mockApiClient(Client::class);

        try {
            $client->getInvitationQrCode(5);
        } catch (\Exception $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
            $this->assertSame('The sizeType must be 1, 2, 3, 4.', $e->getMessage());
        }

        $client->expects()->httpGet('cgi-bin/corp/get_join_qrcode', ['size_type' => 1])->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getInvitationQrCode(1));
    }

    /**
     * 获取企业活跃成员数
     * @return void
     */
    public function testGetActiveStat()
    {
        $client = $this->mockApiClient(Client::class);

        $params = ['date'=>'2021-01-01'];

        $client->expects()->httpPostJson('/cgi-bin/user/get_active_stat', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getActiveStat('2021-01-01'));
    }
}