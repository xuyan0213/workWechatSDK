<?php

namespace WorkWechatSdk\Tests\WeWork\OA;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\OA\Client;


/**
 * 审批
 */
class ClientTest extends TestCase
{

    /**
     * 获取审批模板详情
     * @return void
     */
    public function testGetTemplateDetail()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'template_id' => 'qwe',
        ];
        $client->expects()->httpPostJson('cgi-bin/oa/gettemplatedetail', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getTemplateDetail('qwe'));
    }


    /**
     * 提交审批申请
     * @return void
     */
    public function testCheckinRules()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "creator_userid" => "WangXiaoMing",
            "template_id" => "3Tka1eD6v6JfzhDMqPd3aMkFdxqtJMc2ZRioeFXkaaa",
            "use_template_approver" => 0,
            "choose_department" => 2,
            "approver" => [
                [
                    "attr" => 2,
                    "userid" => [
                        "WuJunJie",
                        "WangXiaoMing"
                    ]
                ]
            ],
            "notifyer" => [
                "WuJunJie",
                "WangXiaoMing"
            ],
            "notify_type" => 1,
            "apply_data" => [
                "contents" => [
                    [
                        "control" => "Text",
                        "id" => "Text-15111111111",
                        "value" => [
                            "text" => "文本填写的内容"
                        ]
                    ]
                ]
            ],
            "summary_list" => [
                [
                    "summary_info" => [
                        [
                            "text" => "摘要第1行",
                            "lang" => "zh_CN"
                        ]
                    ]
                ]
            ]
        ];
        $client->expects()->httpPostJson('cgi-bin/oa/applyevent', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->applyEvent(
            'WangXiaoMing','3Tka1eD6v6JfzhDMqPd3aMkFdxqtJMc2ZRioeFXkaaa',
            [
            [
                "attr" => 2,
                "userid" => [
                    "WuJunJie",
                    "WangXiaoMing"
                ]
            ]
        ],[
                "contents" => [
                    [
                        "control" => "Text",
                        "id" => "Text-15111111111",
                        "value" => [
                            "text" => "文本填写的内容"
                        ]
                    ]
                ]
            ],[
                [
                    "summary_info" => [
                        [
                            "text" => "摘要第1行",
                            "lang" => "zh_CN"
                        ]
                    ]
                ]
            ],0,2,1,[
                "WuJunJie",
                "WangXiaoMing"
            ]
        ));
    }

    /**
     * 批量获取审批单号
     * @return void
     */
    public function testGetApprovalInfo()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'starttime' => 123,
            'endtime' => 456,
            'cursor' => 0,
            'size' => 100,
            'filters' => [
                'key'=>'template_id',
                'value'=>'qwe'
            ],
        ];

        $client->expects()->httpPostJson('cgi-bin/oa/getapprovalinfo',$params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getApprovalInfo(123,456,0,100,
        [
            'key'=>'template_id',
            'value'=>'qwe'
        ]));
    }

    /**
     * 获取审批申请详情
     * @return void
     */
    public function testGetApprovalDetail()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'sp_no' => 123,
        ];

        $client->expects()->httpPostJson('cgi-bin/oa/getapprovaldetail', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getApprovalDetail(123));
    }

    /**
     * 获取审批数据（旧）
     * @return void
     */
    public function testGetApprovalData()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'starttime' => 123,
            'endtime' => 456,
            'next_spnum' => 789,
        ];

        $client->expects()->httpPostJson('cgi-bin/corp/getapprovaldata', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getApprovalData(123,456,789));
    }

    /**
     * 获取企业假期管理配置
     * @return void
     */
    public function testGetCorpConf()
    {
        $client = $this->mockApiClient(Client::class);

        $client->expects()->httpPostJson('cgi-bin/oa/vacation/getcorpconf')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getCorpConf());
    }

    /**
     * 获取成员假期余额
     * @return void
     */
    public function testGetUserVacationQuota()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'userid' => 'aaa'
        ];

        $client->expects()->httpPostJson('cgi-bin/oa/vacation/getuservacationquota', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getUserVacationQuota('aaa'));
    }

    /**
     * 修改成员假期余额
     * @return void
     */
    public function testSetOneUserQuota()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "userid" => "ZhangSan",
            "vacation_id" => 1,
            "leftduration" => 604800,
            "time_attr" => 1,
            "remarks" => "PLACE_HOLDER"
        ];

        $client->expects()->httpPostJson('cgi-bin/oa/vacation/setoneuserquota', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->setOneUserQuota(
            'ZhangSan',1,604800,1,'PLACE_HOLDER'
        ));
    }
}