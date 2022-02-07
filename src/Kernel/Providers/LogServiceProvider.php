<?php


namespace WorkWechatSdk\Kernel\Providers;

use WorkWechatSdk\Kernel\Log\LogManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;


class LogServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $pimple 容器实例
     */
    public function register(Container $pimple)
    {
        $pimple['logger'] = $pimple['log'] = function ($app) {
            $config = $this->formatLogConfig($app);

            if (!empty($config)) {
                $app->rebind('config', $app['config']->merge($config));
            }

            return new LogManager($app);
        };
    }

    /**
     * 格式化日志配置
     * @param $app
     * @return array[]
     */
    public function formatLogConfig($app)
    {
        if (!empty($app['config']->get('log.channels'))) {
            return $app['config']->get('log');
        }

        if (empty($app['config']->get('log'))) {
            return [
                'log' => [
                    'default' => 'errorlog',
                    'channels' => [
                        'errorlog' => [
                            'driver' => 'errorlog',
                            'level' => 'debug',
                        ],
                    ],
                ],
            ];
        }

        return [
            'log' => [
                'default' => 'single',
                'channels' => [
                    'single' => [
                        'driver' => 'single',
                        'path' => $app['config']->get('log.file') ?: \sys_get_temp_dir().'/logs/work_wechat.log',
                        'level' => $app['config']->get('log.level', 'debug'),
                    ],
                ],
            ],
        ];
    }
}
