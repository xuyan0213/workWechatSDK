<?php

namespace WorkWechatSdk\Tests;

use Mockery;
use WorkWechatSdk\Kernel\AccessToken;
use WorkWechatSdk\Kernel\ServiceContainer;
use PHPUnit\Framework\TestCase as BaseTestCase;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

/**
 * class TestCase.
 */
class TestCase extends BaseTestCase
{
    use ArraySubsetAsserts;

    /**
     * 创建API Client模拟对象
     *
     * @param string                                   $name
     * @param array|string                             $methods
     * @param ServiceContainer|null $app
     *
     * @return \Mockery\Mock
     */
    public function mockApiClient($name, $methods = [], ServiceContainer $app = null)
    {
        $methods = implode(',', array_merge([
            'httpGet', 'httpPost', 'httpPostJson', 'httpUpload',
            'request', 'requestRaw', 'requestArray', 'registerMiddlewares',
        ], (array) $methods));

        $client = \Mockery::mock(
            $name."[{$methods}]",
            [
                $app ?? \Mockery::mock(ServiceContainer::class),
                \Mockery::mock(AccessToken::class)]
        )->shouldAllowMockingProtectedMethods();//允许模拟受保护的方法
        $client->allows()->registerHttpMiddlewares()->andReturnNull();
        return $client;
    }

    /**
     * 分解测试用例
     */
    public function tearDown(): void
    {
        $this->finish();
        parent::tearDown();
        if ($container = \Mockery::getContainer()) {
            $this->addToAssertionCount($container->Mockery_getExpectationCount());
        }
        \Mockery::close();
    }

    /**
     * 销毁代码
     */
    protected function finish()
    {
        // call more tear down methods
    }
}