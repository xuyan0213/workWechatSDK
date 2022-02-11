<?php


namespace WorkWechatSdk\OpenWeWork\Provider;

use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\BaseClient;
use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\ServiceContainer;
use WorkWechatSdk\Kernel\Support\Collection;


class Client extends BaseClient
{

    public function __construct(ServiceContainer $app)
    {
        parent::__construct($app, $app['provider_access_token']);
    }

    /**
     * 扫码授权登录
     *
     * @see https://developer.work.weixin.qq.com/document/path/91124
     *
     * @param string $redirectUri 授权登录之后目的跳转网址，需要做urlencode处理。所在域名需要与授权完成回调域名一致
     * @param string $userType 支持登录的类型。admin代表管理员登录（使用微信扫码）,member代表成员登录（使用企业微信扫码），默认为admin
     * @param string $state 用于企业或服务商自行校验session，防止跨域攻击
     *
     * @return string
     */
    public function getLoginUrl(string $redirectUri = '', string $userType = 'admin', string $state = ''): string
    {
        $redirectUri || $redirectUri = $this->app->config['redirect_uri_single'];
        $state || $state = rand();
        $params = [
            'appid' => $this->app['config']['corp_id'],
            'redirect_uri' => $redirectUri,
            'usertype' => $userType,
            'state' => $state,
        ];

        return 'https://open.work.weixin.qq.com/wwopen/sso/3rd_qrConnect?'.http_build_query($params);
    }

    /**
     * 单点登录 - 获取登录用户信息.
     *
     * @see https://developer.work.weixin.qq.com/document/path/91125
     *
     * @param string $authCode 	oauth2.0授权企业微信管理员登录产生的code，最长为512字节。只能使用一次，5分钟未被使用自动过期
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     */
    public function getLoginInfo(string $authCode)
    {
        $params = [
            'auth_code' => $authCode,
        ];

        return $this->httpPostJson('cgi-bin/service/get_login_info', $params);
    }

    /**
     * 获取注册定制化URL.
     *
     * @see https://developer.work.weixin.qq.com/document/path/90578
     *
     * @param string $registerCode
     *
     * @return string
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     */
    public function getRegisterUri(string $registerCode = ''): string
    {
        if (!$registerCode) {
            /** @var array $response */
            $response = $this->detectAndCastResponseToType($this->getRegisterCode(), 'array');

            $registerCode = $response['register_code'];
        }

        $params = ['register_code' => $registerCode];

        return 'https://open.work.weixin.qq.com/3rdservice/wework/register?'.http_build_query($params);
    }

    /**
     * 获取注册码.
     *
     * @see https://developer.work.weixin.qq.com/document/path/90581
     *
     * @param string $corpName 企业名称
     * @param string $adminName 	管理员姓名
     * @param string $adminMobile 管理员手机号
     * @param string $state 用户自定义的状态值。
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     */
    public function getRegisterCode(
        string $corpName = '',
        string $adminName = '',
        string $adminMobile = '',
        string $state = ''
    ) {
        $params = [];
        $params['template_id'] = $this->app['config']['reg_template_id'];
        !empty($corpName) && $params['corp_name'] = $corpName;
        !empty($adminName) && $params['admin_name'] = $adminName;
        !empty($adminMobile) && $params['admin_mobile'] = $adminMobile;
        !empty($state) && $params['state'] = $state;

        return $this->httpPostJson('cgi-bin/service/get_register_code', $params);
    }

    /**
     * 查询注册状态.
     *
     * Desc:该API用于查询企业注册状态，企业注册成功返回注册信息.
     *
     * @see https://developer.work.weixin.qq.com/document/path/90582
     *
     * @param string $registerCode
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRegisterInfo(string $registerCode)
    {
        $params = [
            'register_code' => $registerCode,
        ];

        return $this->httpPostJson('cgi-bin/service/get_register_info', $params);
    }

    /**
     * 设置授权应用可见范围.
     *
     * Desc:调用该接口前提是开启通讯录迁移，收到授权成功通知后可调用。
     *      企业注册初始化安装应用后，应用默认可见范围为根部门。
     *      如需修改应用可见范围，服务商可以调用该接口设置授权应用的可见范围。
     *      该接口只能使用注册完成回调事件或者查询注册状态返回的access_token。
     *      调用设置通讯录同步完成后或者access_token超过30分钟失效（即解除通讯录锁定状态）则不能继续调用该接口。
     *
     * @param string $accessToken
     * @param string $agentId
     * @param array  $allowUser
     * @param array  $allowParty
     * @param array  $allowTag
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @see https://developer.work.weixin.qq.com/document/path/90583
     * @throws InvalidConfigException
     */
    public function setAgentScope(
        string $accessToken,
        string $agentId,
        array $allowUser = [],
        array $allowParty = [],
        array $allowTag = []
    ) {
        $params = [
            'agentid' => $agentId,
            'allow_user' => $allowUser,
            'allow_party' => $allowParty,
            'allow_tag' => $allowTag,
            'access_token' => $accessToken,
        ];

        return $this->httpGet('cgi-bin/agent/set_scope', $params);
    }

    /**
     * 设置通讯录同步完成.
     *
     * Desc:该API用于设置通讯录同步完成，解除通讯录锁定状态，同时使通讯录迁移access_token失效。
     *
     * @see https://developer.work.weixin.qq.com/document/path/90584
     * @param string $accessToken
     *
     * @return array|Collection|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     */
    public function contactSyncSuccess(string $accessToken)
    {
        $params = ['access_token' => $accessToken];

        return $this->httpGet('cgi-bin/sync/contact_sync_success', $params);
    }
}
