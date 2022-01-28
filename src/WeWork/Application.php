<?php


namespace WorkWechatSdk\WeWork;

use WorkWechatSdk\Kernel\ServiceContainer;
use WorkWechatSdk\WeWork\ExternalContact\ContactWayClient;
use WorkWechatSdk\WeWork\ExternalContact\GroupChatClient;
use WorkWechatSdk\WeWork\ExternalContact\MessageClient;
use WorkWechatSdk\WeWork\ExternalContact\MomentClient;
use WorkWechatSdk\WeWork\ExternalContact\StatisticsClient;
use WorkWechatSdk\WeWork\ExternalContact\TransferCustomerClient;
use WorkWechatSdk\WeWork\Message\Messenger;
use WorkWechatSdk\WeWork\MiniProgram\Application as MiniProgram;

/**
 * Application.
 *
 * @property Agent\Client               $agent              应用管理
 * @property Agent\WorkbenchClient      $workbench          应用工作台
 *
 * @property AppChat\Client             $app_chat           群聊会话
 *
 * @property Auth\AccessToken           $access_token       accessToken
 *
 * @property Base\Client                $base               通用接口
 *
 * @property CorpGroup\Client           $corp_group         企业互联
 *
 * @property ExternalContact\Client     $external_contact   客户联系-客户管理
 * @property ContactWayClient           $contact_way        客户联系-联系我与客户入群方式
 * @property GroupChatClient            $group_chat         客户联系-客户群
 * @property MessageClient              $group_send         客户联系-消息推送
 * @property MomentClient               $moment             客户联系-朋友圈
 * @property StatisticsClient           $statistics         客户联系-获取「联系客户统计」数据
 * @property ExternalContact\TagClient  $external_contact_tag 客户联系-客户标签管理
 * @property TransferCustomerClient     $transfer_customer   客户联系-在职/离职继承
 *
 * @property Jssdk\Client               $jssdk              JS-SDK
 *
 * @property Media\Client               $media              素材管理
 *
 * @property Message\Client             $message            消息推送
 *
 * @property MsgAudit\Client            $msg_audit          会话内容存档
 *
 * @property OA\CalendarClient          $calendar           效率工具-日程
 * @property OA\CheckinClient           $checkin            OA-打卡
 * @property OA\CalendarClient          $oa                 OA-审批
 *
 * @property User\BatchJobsClient       $batch_jobs         通讯录管理-异步批量接口
 * @property User\Client                $user               通讯录管理-成员管理
 * @property User\DepartmentClient      $department         通讯录管理-部门管理
 * @property User\TagClient             $user_tag           通讯录管理-标签管理
 *
 * @method mixed getCallbackIp()
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected array $providers = [
        Agent\ServiceProvider::class,           //应用模块
        AppChat\ServiceProvider::class,           //应用模块
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        CorpGroup\ServiceProvider::class,
        ExternalContact\ServiceProvider::class,
        Jssdk\ServiceProvider::class,
        Media\ServiceProvider::class,
        Message\ServiceProvider::class,
        MsgAudit\ServiceProvider::class,
        OA\ServiceProvider::class,
        OAuth\ServiceProvider::class,
        Server\ServiceProvider::class,
        User\ServiceProvider::class,
    ];

    /**
     * @var array
     */
    protected array $defaultConfig = [
        // http://docs.guzzlephp.org/en/stable/request-options.html
        'http' => [
            'base_uri' => 'https://qyapi.weixin.qq.com/',
        ],
    ];

    /**
     * @return MiniProgram
     */
    public function miniProgram(): MiniProgram
    {
        return new MiniProgram($this->getConfig());
    }

    /**
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        return $this['base']->$method(...$arguments);
    }
}
