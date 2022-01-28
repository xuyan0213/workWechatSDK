<?php

namespace WorkWechatSdk\WeWork\OAuth;

use Overtrue\Socialite\User;
use WorkWechatSdk\WeWork\Application;
use Overtrue\Socialite\Contracts\ProviderInterface;
use Overtrue\Socialite\SocialiteManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @method $this scopes(array $scopes)
 * @method $this setAgentId(string $agentId)
 */
class Manager
{
    protected array $config;

    /**
     * @var ProviderInterface
     */
    protected ProviderInterface $provider;
    protected Application $app;

    public function __construct(array $config, Application $app)
    {
        $this->config = $config;
        $this->app = $app;
    }

    /**
     * @param $redirect
     * @return RedirectResponse
     */
    public function redirect($redirect = null): RedirectResponse
    {
        return new RedirectResponse($this->getProvider()->redirect($redirect));
    }

    /**
     * @return User
     */
    public function user(): User
    {
        $this->getProvider()->withApiAccessToken($this->app['access_token']->getToken()['access_token']);

        return $this->getProvider()->userFromCode($this->app->request->get('code'));
    }

    protected function getProvider(): ProviderInterface
    {
        return $this->provider ?? $this->provider = (new SocialiteManager($this->config))->create('wework');
    }

    public function __call($name, $arguments)
    {
        return \call_user_func_array([$this->getProvider(), $name], $arguments);
    }
}
