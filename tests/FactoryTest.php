<?php


namespace WorkWechatSdk\Tests;

use WorkWechatSdk\Factory;
use WorkWechatSdk\WeWork\Application;

class FactoryTest extends TestCase
{
    public function testStaticCall()
    {
        $this->assertInstanceOf(
            Application::class,
            Factory::we_work(['appid' => '123'])
        );
    }
}