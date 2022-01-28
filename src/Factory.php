<?php


namespace WorkWechatSdk;

use WorkWechatSdk\Kernel\ServiceContainer;
use WorkWechatSdk\WeWork\Application;

/**
 * Class Factory.
 *
 * @method static Application we_work(array $config)
 */
class Factory
{
    /**
     * @param string $name
     * @param array $config
     *
     * @return ServiceContainer
     */
    public static function make(string $name, array $config): ServiceContainer
    {
        $namespace = Kernel\Support\Str::studly($name);
        $application = "\\WorkWechatSdk\\{$namespace}\\Application";

        return new $application($config);
    }

    /**
     * 动态地将方法传递给应用程序.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return ServiceContainer
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return self::make($name, ...$arguments);
    }
}
