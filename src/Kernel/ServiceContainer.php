<?php


namespace WorkWechatSdk\Kernel;

use GuzzleHttp\Client;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use WorkWechatSdk\Kernel\Providers\ConfigServiceProvider;
use WorkWechatSdk\Kernel\Providers\EventDispatcherServiceProvider;
use WorkWechatSdk\Kernel\Providers\ExtensionServiceProvider;
use WorkWechatSdk\Kernel\Providers\HttpClientServiceProvider;
use WorkWechatSdk\Kernel\Providers\LogServiceProvider;
use WorkWechatSdk\Kernel\Providers\RequestServiceProvider;
use EasyWeChatComposer\Traits\WithAggregator;
use Pimple\Container;

/**
 * Class ServiceContainer.
 *
 * @property Config $config
 * @property Request $request
 * @property Client $http_client
 * @property Logger $logger
 * @property EventDispatcher $events
 */
class ServiceContainer extends Container
{
    use WithAggregator;

    /**
     * @var string
     */
    protected  $id;

    /**
     * @var array
     */
    protected array $providers = [];

    /**
     * @var array
     */
    protected array $defaultConfig = [];

    /**
     * @var array
     */
    protected array $userConfig = [];

    /**
     * Constructor.
     *
     * @param array $config
     * @param array $prepends
     * @param string|null $id
     */
    public function __construct(array $config = [], array $prepends = [], string $id = null)
    {
        $this->userConfig = $config;

        parent::__construct($prepends);

        $this->registerProviders($this->getProviders());

        $this->id = $id;

        $this->aggregate();

        $this->events->dispatch(new Events\ApplicationInitialized($this));
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id ?? $this->id = md5(json_encode($this->userConfig));
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        $base = [
            // http://docs.guzzlephp.org/en/stable/request-options.html
            'http' => [
                'timeout' => 30.0,
                'base_uri' => 'https://api.weixin.qq.com/',
            ],
        ];

        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig);
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders(): array
    {
        return array_merge([
            ConfigServiceProvider::class,               //配置服务提供商
            LogServiceProvider::class,                  //日志服务提供货商
            RequestServiceProvider::class,              //请求服务提供商
            HttpClientServiceProvider::class,           //Http客户端服务提供商
            ExtensionServiceProvider::class,            //扩展服务提供商
            EventDispatcherServiceProvider::class,      //事件调度服务提供商
        ], $this->providers);
    }

    /**
     * 重新设置/绑定 服务或参数
     * @param string $id
     * @param mixed $value
     */
    public function rebind(string $id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get(string $id)
    {
        if ($this->shouldDelegate($id)) {
            return $this->delegateTo($id);
        }

        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed $value
     */
    public function __set(string $id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}