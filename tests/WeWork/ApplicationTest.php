<?php


namespace WorkWechatSdk\Tests\WeWork;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\Application;
use WorkWechatSdk\WeWork\Base\Client;
use WorkWechatSdk\WeWork;

class ApplicationTest extends TestCase
{
    public function testInstances()
    {
        $app = new Application([
            'corp_id' => '333555',
            'agent_id' => 100000,
            'secret' => 'weerttyuui',
        ]);
        $this->assertInstanceOf(WeWork\Agent\Client::class, $app->agent);
        $this->assertInstanceOf(WeWork\Agent\WorkbenchClient::class, $app->workbench);
        $this->assertInstanceOf(WeWork\AppChat\Client::class, $app->app_chat);
        $this->assertInstanceOf(WeWork\Auth\AccessToken::class, $app->access_token);
        $this->assertInstanceOf(WeWork\Base\Client::class, $app->base);
        $this->assertInstanceOf(WeWork\CorpGroup\Client::class, $app->corp_group);
        $this->assertInstanceOf(WeWork\ExternalContact\Client::class, $app->external_contact);
        $this->assertInstanceOf(WeWork\ExternalContact\ContactWayClient::class, $app->contact_way);
        $this->assertInstanceOf(WeWork\ExternalContact\GroupChatClient::class, $app->group_chat);
        $this->assertInstanceOf(WeWork\ExternalContact\MessageClient::class, $app->group_send);
        $this->assertInstanceOf(WeWork\ExternalContact\MomentClient::class, $app->moment);
        $this->assertInstanceOf(WeWork\ExternalContact\StatisticsClient::class, $app->statistics);
        $this->assertInstanceOf(WeWork\ExternalContact\TagClient::class, $app->external_contact_tag);
        $this->assertInstanceOf(WeWork\ExternalContact\TransferCustomerClient::class, $app->transfer_customer);
        $this->assertInstanceOf(WeWork\Jssdk\Client::class, $app->jssdk);
        $this->assertInstanceOf(WeWork\Media\Client::class, $app->media);
        $this->assertInstanceOf(WeWork\Message\Client::class, $app->message);
        $this->assertInstanceOf(WeWork\MsgAudit\Client::class, $app->msg_audit);
        $this->assertInstanceOf(WeWork\OA\CalendarClient::class, $app->calendar);
        $this->assertInstanceOf(WeWork\OA\CheckinClient::class, $app->checkin);
        $this->assertInstanceOf(WeWork\OA\CalendarClient::class, $app->oa);
        $this->assertInstanceOf(WeWork\User\BatchJobsClient::class, $app->batch_jobs);
        $this->assertInstanceOf(WeWork\User\Client::class, $app->user);
        $this->assertInstanceOf(WeWork\User\DepartmentClient::class, $app->department);
        $this->assertInstanceOf(WeWork\User\TagClient::class, $app->user_tag);
    }


    public function testBaseCall()
    {
        $client = \Mockery::mock(Client::class);

        $client->expects()->getCallbackIp(1, 2, 3)->andReturn('mock-result');

        $app = new Application([]);
        $app['base'] = $client;
        $this->assertSame('mock-result', $app->getCallbackIp(1, 2, 3));
    }
}