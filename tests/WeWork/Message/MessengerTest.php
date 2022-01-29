<?php

namespace WorkWechatSdk\Tests\WeWork\Message;


use GuzzleHttp\Exception\GuzzleException;
use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Exceptions\RuntimeException;
use WorkWechatSdk\Kernel\Messages\Raw;
use WorkWechatSdk\Kernel\Messages\Text;
use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\Message\Messenger;
use WorkWechatSdk\WeWork\Message\Client;


/**
 * 消息推送
 */
class MessengerTest extends TestCase
{

    public function testMessage()
    {
        $client = \Mockery::mock(Client::class);
        $messenger = new Messenger($client);

        $this->assertInstanceOf(Text::class, $messenger->message('hello world!')->message);
        $this->assertInstanceOf(Text::class, $messenger->message(12345)->message);

        // invalid property
        try {
            $messenger->foo;
        } catch (\Exception $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
            $this->assertSame('未找到"foo"的属性值', $e->getMessage());
        }

        // invalid
        try {
            $messenger->message(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
            $this->assertSame('消息无效', $e->getMessage());
        }

        try {
            $messenger->message([]);
        } catch (\Exception $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
            $this->assertSame('消息无效', $e->getMessage());
        }

        try {
            $messenger->message(new \stdClass());
        } catch (\Exception $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
            $this->assertSame('消息无效', $e->getMessage());
        }
    }

    /**
     * 设置企微ID
     * @return void
     */
    public function testAgentId()
    {
        $client = \Mockery::mock(Client::class);
        $messenger = new Messenger($client);

        $this->assertSame(12345, $messenger->ofAgent(12345)->agentId);
    }

    public function testSetRecipients()
    {
        $client = \Mockery::mock(Client::class);
        $messenger = new Messenger($client);

        // 默认全员推送
        $this->assertSame(['touser' => '@all'], $messenger->to);

        //推送指定成员和指定部门
        $this->assertSame(['touser' => 'aaa', 'toparty' => 'party1'],
            $messenger->toUser('aaa')->toParty('party1')->to);
//        // 推送指定成员
//        $this->assertSame(['touser' => 'aaa'], $messenger->toUser('aaa')->to);
//        $this->assertSame(['touser' => 'aaa|bbb'], $messenger->toUser(['aaa', 'bbb'])->to);
//
//        // 推送指定成员和指定部门
//        $this->assertSame(['touser' => 'aaa|bbb', 'toparty' => 'party1'], $messenger->toParty('party1')->to);
//        $this->assertSame(['touser' => 'aaa|bbb', 'toparty' => 'party1|party2'], $messenger->toParty(['party1', 'party2'])->to);
//
//        // 推送指定成员和指定部门以及指定标签
//        $this->assertSame(['touser' => 'aaa|bbb', 'toparty' => 'party1|party2', 'totag' => 'tag1'], $messenger->toTag('tag1')->to);
//        $this->assertSame(['touser' => 'aaa|bbb', 'toparty' => 'party1|party2', 'totag' => 'tag1|tag2'], $messenger->toTag(['tag1', 'tag2'])->to);
    }


    /**
     * @return void
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws InvalidConfigException
     * @throws RuntimeException
     */
    public function testSecretive()
    {
        $client = \Mockery::mock(Client::class);
        $messenger = new Messenger($client);

        $this->assertFalse($messenger->secretive);
//        $this->assertTrue($messenger->secretive()->secretive);

        $message = new Raw(json_encode([
            'touser' => '@all',
            'msgtype' => 'text',
            'agentid' => 123456,
            'safe' => 0,
            'text' => [
                'content' => 'hello world!',
            ],
        ]));
        $client->expects()->send([
            'touser' => '@all',
            'msgtype' => 'text',
            'agentid' => 123456,
            'safe' => 0,
            'text' => [
                'content' => 'hello world!',
            ],
        ])->andReturn('mock-result');

        $messenger->message($message)->ofAgent(123456)/*->secretive()*/->send();
        $this->assertFalse($messenger->secretive);
    }

    /**
     * @return void
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws RuntimeException
     */
    public function testSend()
    {
        $client = \Mockery::mock(Client::class);
        $messenger = new Messenger($client);

        // no message
        try {
            $messenger->send();
            $this->fail('No expected exception thrown.');
        } catch (\Exception $e) {
            $this->assertSame('消息不能为空', $e->getMessage());
        }

        // no agentid
        $client = \Mockery::mock(Client::class);
        $messenger = new Messenger($client);

        try {
            $messenger->send('123');
            $this->fail('No expected exception thrown.');
        } catch (\Exception $e) {
            $this->assertSame('未找到指定应用ID', $e->getMessage());
        }

        // raw message
        $client = \Mockery::mock(Client::class);
        $messenger = new Messenger($client);
        $message = new Raw(json_encode([
            'touser' => '@all',
            'msgtype' => 'text',
            'agentid' => 123456,
            'safe' => 0,
            'text' => [
                'content' => 'hello world!',
            ],
        ]));
        $client->expects()->send([
            'touser' => '@all',
            'msgtype' => 'text',
            'agentid' => 123456,
            'safe' => 0,
            'text' => [
                'content' => 'hello world!',
            ],
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $messenger->message($message)->ofAgent(123456)->send());

        // not raw message
        $client = \Mockery::mock(Client::class);
        $messenger = new Messenger($client);
        $client->expects()->send([
            'touser' => '@all',
            'msgtype' => 'text',
            'agentid' => 123456,
            'safe' => 0,
            'text' => [
                'content' => 'hello world!',
            ],
        ])->andReturn('mock-result');

        $this->assertSame('mock-result', $messenger->ofAgent(123456)->send('hello world!'));
    }


}