<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\Kernel\Log;

use Closure;
use Exception;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\MissingExtensionException;
use WorkWechatSdk\Kernel\ServiceContainer;
use InvalidArgumentException;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\FormattableHandlerInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\SlackWebhookHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogHandler;
use Monolog\Handler\WhatFailureGroupHandler;
use Monolog\Logger as Monolog;
use Psr\Log\LoggerInterface;

/**
 * 日置管理类
 *
 */
class LogManager implements LoggerInterface
{
    /**
     * @var ServiceContainer
     */
    protected $app;

    /**
     * 解析通道
     *
     * @var array
     */
    protected $channels = [];

    /**
     * 自定义创建者
     *
     * @var array
     */
    protected $customCreators = [];

    /**
     * 日志等级
     *
     * @var array
     */
    protected $levels = [
        'debug' => Monolog::DEBUG,
        'info' => Monolog::INFO,
        'notice' => Monolog::NOTICE,
        'warning' => Monolog::WARNING,
        'error' => Monolog::ERROR,
        'critical' => Monolog::CRITICAL,
        'alert' => Monolog::ALERT,
        'emergency' => Monolog::EMERGENCY,
    ];

    /**
     *
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * 创建一个新的、随需应变的聚合日志记录器实例。
     *
     * @param array       $channels
     * @param string|null $channel
     *
     * @return LoggerInterface
     *
     * @throws Exception
     */
    public function stack(array $channels, string $channel = null)
    {
        return $this->createStackDriver(compact('channels', 'channel'));
    }

    /**
     * 获取一个日志通道实例
     *
     * @param string|null $channel
     *
     * @return LoggerInterface|Monolog
     *
     * @throws Exception
     */
    public function channel(string $channel = null)
    {
        return $this->driver($channel);
    }

    /**
     * 获取一个日志驱动程序实例
     *
     * @param string|null $driver
     *
     * @return LoggerInterface|Monolog
     *
     * @throws Exception
     */
    public function driver(string $driver = null)
    {
        return $this->get($driver ?? $this->getDefaultDriver());
    }

    /**
     * 从本地缓存获取日志
     *
     * @param string $name
     *
     * @return LoggerInterface
     *
     * @throws Exception
     */
    protected function get(string $name)
    {
        try {
            return $this->channels[$name] ?? ($this->channels[$name] = $this->resolve($name));
        } catch (\Throwable $e) {
            $logger = $this->createEmergencyLogger();

            $logger->emergency('Unable to create configured logger. Using emergency logger.', [
                'exception' => $e,
            ]);

            return $logger;
        }
    }

    /**
     * 按名称解析给定的日志实例
     *
     * @param string $name
     *
     * @return LoggerInterface
     *
     * @throws InvalidArgumentException
     */
    protected function resolve(string $name): LoggerInterface
    {
        $config = $this->app['config']->get(\sprintf('log.channels.%s', $name));

        if (is_null($config)) {
            throw new InvalidArgumentException(\sprintf('Log [%s] is not defined.', $name));
        }

        if (isset($this->customCreators[$config['driver']])) {
            return $this->callCustomCreator($config);
        }

        $driverMethod = 'create'.ucfirst($config['driver']).'Driver';

        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($config);
        }

        throw new InvalidArgumentException(\sprintf('Driver [%s] is not supported.', $config['driver']));
    }

    /**
     * 创建一个紧急日志处理程序，以避免死机
     *
     * @return Monolog
     *
     * @throws Exception
     */
    protected function createEmergencyLogger(): Monolog
    {
        return new Monolog('workWeChat', $this->prepareHandlers([new StreamHandler(
            \sys_get_temp_dir().'/work_wechat_sdk/work_wechat_sdk.log',
            $this->level(['level' => 'debug'])
        )]));
    }

    /**
     * 调用自定义驱动程序创建者
     *
     * @param array $config
     *
     * @return mixed
     */
    protected function callCustomCreator(array $config)
    {
        return $this->customCreators[$config['driver']]($this->app, $config);
    }

    /**
     * 创建聚合日志驱动程序实例
     *
     * @param array $config
     *
     * @return Monolog
     *
     * @throws Exception
     */
    protected function createStackDriver(array $config): Monolog
    {
        $handlers = [];

        foreach ($config['channels'] ?? [] as $channel) {
            $handlers = \array_merge($handlers, $this->channel($channel)->getHandlers());
        }

        if ($config['ignore_exceptions'] ?? false) {
            $handlers = [new WhatFailureGroupHandler($handlers)];
        }

        return new Monolog($this->parseChannel($config), $handlers);
    }

    /**
     * 创建单个文件日志驱动程序的实例
     *
     * @param array $config
     *
     * @return LoggerInterface
     *
     * @throws Exception
     */
    protected function createSingleDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new StreamHandler(
                $config['path'],
                $this->level($config),
                $config['bubble'] ?? true,
                $config['permission'] ?? null,
                $config['locking'] ?? false
            ), $config),
        ]);
    }

    /**
     * 创建一个每日文件日志驱动程序实例
     *
     * @param array $config
     *
     * @return LoggerInterface
     */
    protected function createDailyDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new RotatingFileHandler(
                $config['path'],
                $config['days'] ?? 7,
                $this->level($config),
                $config['bubble'] ?? true,
                $config['permission'] ?? null,
                $config['locking'] ?? false
            ), $config),
        ]);
    }

    /**
     * 创建一个Slack日志驱动程序实例
     *
     * @param  array  $config
     *
     * @return LoggerInterface
     */
    protected function createSlackDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new SlackWebhookHandler(
                $config['url'],
                $config['channel'] ?? null,
                $config['username'] ?? 'EasyWeChat',
                $config['attachment'] ?? true,
                $config['emoji'] ?? ':boom:',
                $config['short'] ?? false,
                $config['context'] ?? true,
                $this->level($config),
                $config['bubble'] ?? true,
                $config['exclude_fields'] ?? []
            ), $config),
        ]);
    }

    /**
     * 创建syslog日志驱动的实例
     *
     * @param array $config
     *
     * @return LoggerInterface
     */
    protected function createSyslogDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(new SyslogHandler(
                'EasyWeChat',
                $config['facility'] ?? LOG_USER,
                $this->level($config)
            ), $config),
        ]);
    }

    /**
     * 创建ErrorLog日志驱动程序的实例。
     *
     * @param array $config
     *
     * @return LoggerInterface
     */
    protected function createErrorlogDriver(array $config)
    {
        return new Monolog($this->parseChannel($config), [
            $this->prepareHandler(
                new ErrorLogHandler(
                    $config['type'] ?? ErrorLogHandler::OPERATING_SYSTEM,
                    $this->level($config)
                )
            ),
        ]);
    }

    /**
     * 准备由Monolog使用的处理程序
     *
     * @param array $handlers
     *
     * @return array
     */
    protected function prepareHandlers(array $handlers): array
    {
        foreach ($handlers as $key => $handler) {
            $handlers[$key] = $this->prepareHandler($handler);
        }

        return $handlers;
    }

    /**
     * 准备由Monolog使用的处理程序
     *
     * @param HandlerInterface $handler
     * @param  array  $config
     *
     * @return HandlerInterface
     */
    protected function prepareHandler(HandlerInterface $handler, array $config = [])
    {
        if (!isset($config['formatter'])) {
            if ($handler instanceof FormattableHandlerInterface) {
                $handler->setFormatter($this->formatter());
            }
        }

        return $handler;
    }

    /**
     * 获取一个Monolog formatter实例
     *
     * @return FormatterInterface
     */
    protected function formatter()
    {
        $formatter = new LineFormatter(null, null, true, true);
        $formatter->includeStacktraces();

        return $formatter;
    }

    /**
     * 从给定的配置中提取日志通道
     *
     * @param array $config
     *
     * @return string
     */
    protected function parseChannel(array $config): string
    {
        return $config['name'] ?? 'workWeChat';
    }

    /**
     * 将字符串级别解析为Monolog常量
     *
     * @param array $config
     *
     * @return int
     *
     * @throws InvalidArgumentException
     */
    protected function level(array $config): int
    {
        $level = $config['level'] ?? 'debug';

        if (isset($this->levels[$level])) {
            return $this->levels[$level];
        }

        throw new InvalidArgumentException('Invalid log level.');
    }

    /**
     * 获取默认的日志驱动程序名称
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['log.default'];
    }

    /**
     * 设置默认的日志驱动程序名称
     *
     * @param string $name
     */
    public function setDefaultDriver(string $name)
    {
        $this->app['config']['log.default'] = $name;
    }

    /**
     * 注册自定义驱动程序创建者闭包
     *
     * @param  string  $driver
     * @param Closure $callback
     *
     * @return $this
     */
    public function extend(string $driver, Closure $callback): LogManager
    {
        $this->customCreators[$driver] = $callback->bindTo($this, $this);

        return $this;
    }

    /**
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     *
     * @throws Exception
     */
    public function emergency($message, array $context = [])
    {
        $this->driver()->emergency($message, $context);
    }

    /**
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     *
     * @throws Exception
     */
    public function alert($message, array $context = [])
    {
        $this->driver()->alert($message, $context);
    }

    /**
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function critical($message, array $context = [])
    {
        $this->driver()->critical($message, $context);
    }

    /**
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function error($message, array $context = [])
    {
        $this->driver()->error($message, $context);
    }

    /**
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function warning($message, array $context = [])
    {
        $this->driver()->warning($message, $context);
    }

    /**
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function notice($message, array $context = [])
    {
        $this->driver()->notice($message, $context);
    }

    /**
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function info($message, array $context = [])
    {
        $this->driver()->info($message, $context);
    }

    /**
     *
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function debug($message, array $context = [])
    {
        $this->driver()->debug($message, $context);
    }

    /**
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @throws Exception
     */
    public function log($level, $message, array $context = [])
    {
        $this->driver()->log($level, $message, $context);
    }

    /**
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     * @throws Exception
     */
    public function __call(string $method, array $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
