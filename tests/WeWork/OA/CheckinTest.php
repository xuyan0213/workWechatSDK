<?php

namespace WorkWechatSdk\Tests\WeWork\OA;

use WorkWechatSdk\Tests\TestCase;
use WorkWechatSdk\WeWork\OA\CheckinClient as Client;


/**
 * 打卡
 */
class CheckinTest extends TestCase
{

    /**
     * 获取打卡记录数据
     * @return void
     */
    public function testCheckinRecords()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'opencheckindatatype' => 3,
            'starttime' => 123,
            'endtime' => 456,
            'useridlist' => ['aaa','bbb'],
        ];
        $client->expects()->httpPostJson('cgi-bin/checkin/getcheckindata', $params)->andReturn('mock-result');
        $this->assertSame('mock-result', $client->checkinRecords(
            123,456,['aaa','bbb'],3
        ));
    }


    /**
     * 获取员工打卡规则
     * @return void
     */
    public function testCheckinRules()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'datetime' => 123,
            'useridlist' => ['aaa','bbb'],
        ];
        $client->expects()->httpPostJson('cgi-bin/checkin/getcheckinoption', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->checkinRules(123,['aaa','bbb']));
    }

    /**
     * 获取企业所有打卡规则
     * @return void
     */
    public function testCorpCheckinRules()
    {
        $client = $this->mockApiClient(Client::class);


        $client->expects()->httpPostJson('cgi-bin/checkin/getcorpcheckinoption')->andReturn('mock-result');

        $this->assertSame('mock-result', $client->corpCheckinRules());
    }

    /**
     * 获取打卡日报数据
     * @return void
     */
    public function testCheckinDayData()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'starttime' => 123,
            'endtime' => 456,
            'useridlist' => ['aaa'],
        ];

        $client->expects()->httpPostJson('cgi-bin/checkin/getcheckin_daydata', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->checkinDayData(123,456,['aaa']));
    }

    /**
     * 获取打卡月报数据
     * @return void
     */
    public function testCheckinMonthData()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'starttime' => 123,
            'endtime' => 456,
            'useridlist' => ['aaa'],
        ];

        $client->expects()->httpPostJson('cgi-bin/checkin/getcheckin_monthdata', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->checkinMonthData(123,456,['aaa']));
    }

    /**
     * 获取打卡人员排班信息
     * @return void
     */
    public function testCheckinSchedus()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'starttime' => 123,
            'endtime' => 456,
            'useridlist' => ['aaa'],
        ];

        $client->expects()->httpPostJson('cgi-bin/checkin/getcheckinschedulist', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->checkinSchedus(123,456,['aaa']));
    }

    /**
     * 为打卡人员排班
     * @return void
     */
    public function testSetCheckinSchedus()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'groupid' => 'aaa',
            'items' => [
                'userid'=>'aaa',
                'day'=>5,
                'schedule_id'=>123
            ],
            'yearmonth'=>202201
        ];

        $client->expects()->httpPostJson('cgi-bin/checkin/setcheckinschedulist', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->setCheckinSchedus(
            'aaa',['userid'=>'aaa', 'day'=>5, 'schedule_id'=>123],202201
        ));
    }

    /**
     * 录入打卡人员人脸信息
     * @return void
     */
    public function testAddCheckinUserface()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            'userid' => 'aaa',
            'userface' => 'qwer'
        ];

        $client->expects()->httpPostJson('cgi-bin/checkin/addcheckinuserface', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->addCheckinUserface(
            'aaa','qwer'
        ));
    }

    /**
     * 获取设备打卡数据
     * @return void
     */
    public function testGetHardwareCheckinData()
    {
        $client = $this->mockApiClient(Client::class);
        $params = [
            "filter_type" => 1,
            "starttime" => 123,
            "endtime" => 456,
            "useridlist" => ['aaa']
        ];

        $client->expects()->httpPostJson('/cgi-bin/hardware/get_hardware_checkin_data', $params)->andReturn('mock-result');

        $this->assertSame('mock-result', $client->getHardwareCheckinData(
            123,456,['aaa']
        ));
    }
}