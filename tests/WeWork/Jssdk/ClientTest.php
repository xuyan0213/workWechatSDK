<?php

namespace WorkWechatSdk\Tests\WeWork\Jssdk;


use WorkWechatSdk\Kernel\Http\Response;
use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\Application;
use WorkWechatSdk\WeWork\Jssdk\Client;
use Psr\SimpleCache\CacheInterface;

/**
 * 客户联系-客户管理
 */
class ClientTest extends TestCase
{

    /**
     * 获取企业ID
     * @return void
     */
    public function testGetAppid()
    {
        $client = $this->mockApiClient(Client::class, ['getAppId'], new Application(['corp_id' => 'wx123']))->shouldAllowMockingProtectedMethods();
        $client->expects()->getAppId()->passthru();
//        return $client->getAppId();
        $this->assertSame('wx123', $client->getAppId());
    }


    public function testBuildAgentConfig()
    {
        $client = $this->mockApiClient(Client::class,['agentConfigSignature'],new Application());
        //模拟两次请求
        $client->expects()->agentConfigSignature('agentId', null)->andReturn(['foo' => 'bar'])->twice();
        //第一次
        $config = json_decode($client->buildAgentConfig(['api1', 'api2'], 'agentId'), true);

        $this->assertArrayHasKey('debug', $config);
        $this->assertArrayHasKey('beta', $config);
        $this->assertArrayHasKey('jsApiList', $config);
        $this->assertArrayHasKey('foo', $config);
        $this->assertArrayHasKey('openTagList', $config);

        $this->assertFalse($config['debug']);
        $this->assertFalse($config['beta']);
        $this->assertSame(['api1', 'api2'], $config['jsApiList']);
        $this->assertSame('bar', $config['foo']);

        //第二次 beta: true, debug: true, json:false
        $config = $client->buildAgentConfig(['api1', 'api2'], 'agentId', true, true, false, ['foo', 'bar']);
        $this->assertArrayHasKey('debug', $config);
        $this->assertArrayHasKey('beta', $config);
        $this->assertArrayHasKey('jsApiList', $config);
        $this->assertArrayHasKey('foo', $config);
        $this->assertArrayHasKey('openTagList', $config);

        $this->assertTrue($config['debug']);
        $this->assertTrue($config['beta']);
        $this->assertSame(['api1', 'api2'], $config['jsApiList']);
        $this->assertSame('bar', $config['foo']);
        $this->assertSame(['foo', 'bar'], $config['openTagList']);

    }

    public function testGetAgentConfigArray()
    {
        $client = $this->mockApiClient(Client::class, 'buildAgentConfig', new Application());
        $client->expects()->buildAgentConfig(['api1', 'api2'], 'agentId', true, true, false, [], null)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getAgentConfigArray(['api1', 'api2'], 'agentId', true, true));
    }

    public function testGetTicket()
    {
        $app = new Application([
            'corp_id' => '123456',
        ]);
        $client = $this->mockApiClient(Client::class, ['getCache'], $app);
        $cache = \Mockery::mock(CacheInterface::class);
        $ticket = [
            'ticket' => 'mock-ticket',
            'expires_in' => 7200,
        ];
        $cacheKey = 'WorkWechatSdk.jssdk.ticket.config.123456';
        $client->allows()->getCache()->andReturn($cache);
        $response = new Response(200, [], json_encode($ticket));
        // no refresh and cached
        $cache->expects()->has($cacheKey)->andReturn(true);
        $cache->expects()->get($cacheKey)->andReturn($ticket);

        $this->assertSame($ticket, $client->getTicket());

        // no refresh and no cached
        $cache->expects()->has($cacheKey)->times(2)->andReturn(false, true);
        $cache->expects()->get($cacheKey)->never();
        $cache->expects()->set($cacheKey, $ticket, $ticket['expires_in'] - 500);
        $client->expects()->requestRaw('https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket', 'GET')->andReturn($response);

        $this->assertSame($ticket, $client->getTicket());

        // with refresh and cached
        $cache->expects()->has($cacheKey)->andReturn(true);
        $cache->expects()->get($cacheKey)->never();
        $cache->expects()->set($cacheKey, $ticket, $ticket['expires_in'] - 500);
        $client->expects()->requestRaw('https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket', 'GET')->andReturn($response);
        $this->assertSame($ticket, $client->getTicket(true));
    }

    public function testGetAgentTicket()
    {
        $app = new Application([
            'corp_id' => '123456',
        ]);
        $client = $this->mockApiClient(Client::class, ['getCache'], $app);
        $cache = \Mockery::mock(CacheInterface::class);
        $ticket = [
            'ticket' => 'mock-ticket',
            'expires_in' => 7200,
        ];
        $cacheKey = 'WorkWechatSdk.jssdk.ticket.100014.agent_config.123456';
        $client->allows()->getCache()->andReturn($cache);
        $response = new Response(200, [], json_encode($ticket));
        $cache->expects()->has($cacheKey)->andReturn(true);
        $cache->expects()->get($cacheKey)->andReturn($ticket);
        $this->assertSame($ticket, $client->getAgentTicket(100014));

        // no refresh and no cached
        $cache->expects()->has($cacheKey)->twice()->andReturn(false, true);
        $cache->expects()->get($cacheKey)->never();
        $cache->expects()->set($cacheKey, $ticket, $ticket['expires_in'] - 500);

        $client->expects()
            ->requestRaw('cgi-bin/ticket/get', 'GET', ['query' => ['type' => 'agent_config']])
            ->andReturn($response);

        $this->assertSame($ticket, $client->getAgentTicket(100014));

        // with refresh and cached
        $cache->expects()->has($cacheKey)->andReturn(true);
        $cache->expects()->get($cacheKey)->never();
        $cache->expects()->set($cacheKey, $ticket, $ticket['expires_in'] - 500);

        $client->expects()
            ->requestRaw('cgi-bin/ticket/get', 'GET', ['query' => ['type' => 'agent_config']])
            ->andReturn($response);

        $this->assertSame($ticket, $client->getAgentTicket(100014, true));
    }

    public function testGetTicketSignature()
    {
        $app = new Application();
        $client = $this->mockApiClient(Client::class,['buildSignature'],$app);
        $ticketSignature = sha1(sprintf('jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s', 'a', 'b', 123, 'http'));
        $this->assertSame($ticketSignature, $client->getTicketSignature('a', 'b', 123, 'http'));
    }
}