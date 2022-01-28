<?php

namespace WorkWechatSdk\Tests\WeWork\ExternalContact;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\ExternalContact\TagClient as Client;

/**
 * 客户联系-客户标签管理
 */
class TagClientTest extends TestCase
{

    /**
     * 获取企业标签库
     * @return void
     */
    public function testGetCorpTags()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'tag_id' => ['qwer','tyui'],
            'group_id' => []
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/get_corp_tag_list', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getCorpTags([
            'qwer','tyui'
        ], []
        ));
    }

    /**
     * 添加企业客户标签
     * @return void
     */
    public function testAddCorpTag()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "group_id" => "GROUP_ID",
            "group_name" => "GROUP_NAME",
            "order" => 1,
            "tag" => [
                [
                    "name" => "TAG_NAME_1",
                    "order" => 1
                ],
                [
                    "name" => "TAG_NAME_2",
                    "order" => 2
                ]
            ],
            "agentid" => 1000014
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/add_corp_tag', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->addCorpTag([
            [
                "name" => "TAG_NAME_1",
                "order" => 1
            ],
            [
                "name" => "TAG_NAME_2",
                "order" => 2
            ]
        ],'GROUP_ID','GROUP_NAME',[
            'order'=>1,
            "agentid" => 1000014
        ]));
    }

    /**
     * 编辑企业客户标签
     * @return void
     */
    public function testUpdateCorpTag()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "id" => "TAG_ID",
            "name" => "NEW_TAG_NAME",
            "order" => 1,
            "agentid" => 1000014
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/edit_corp_tag', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->updateCorpTag(
            'TAG_ID','NEW_TAG_NAME',1,1000014
        ));
    }

    /**
     * 删除企业客户标签
     * @return void
     */
    public function testDeleteCorpTag()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "tag_id" => ['qwer','tyui'],
            "group_id" => ['aaa','bbb'],
            'agentid' => 1000014
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/del_corp_tag', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->deleteCorpTag(
            ['qwer','tyui'],['aaa','bbb'],1000014
        ));
    }

    /**
     * 编辑客户企业标签
     * @return void
     */
    public function testMarkTags()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'userid' => 'aaa',
            'external_userid' => 'ww123',
            'add_tag' => ['aaa','bbb'],
            'remove_tag' => ['ccc','ddd']
        ];
        $client->expects()->httpPostJson('cgi-bin/externalcontact/mark_tag', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->markTags(
            'aaa','ww123', ['aaa','bbb'],['ccc','ddd']
        ));
    }
}