<?php

namespace WorkWechatSdk\WeWork\Jssdk;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\BasicService\Jssdk\Client as BaseClient;
use WorkWechatSdk\Kernel\Contracts\AccessTokenInterface;
use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Exceptions\RuntimeException;
use WorkWechatSdk\Kernel\ServiceContainer;
use WorkWechatSdk\Kernel\Support\Collection;

/**
 * JS-SDK
 */
class Client extends BaseClient
{
    protected string $ticketEndpoint = '/cgi-bin/get_jsapi_ticket';

    public function __construct(ServiceContainer $app, AccessTokenInterface $accessToken = null)
    {
        parent::__construct($app, $accessToken);

        $this->ticketEndpoint = \rtrim($app->config->get('http.base_uri'), '/') . '/cgi-bin/get_jsapi_ticket';
    }

    /**
     * @return string
     */
    protected function getAppId(): string
    {
        return $this->app['config']->get('corp_id');
    }

    /**
     * Return jsapi agent config as a PHP array.
     *
     * @param array $apis
     * @param int|string $agentId
     * @param bool $debug
     * @param bool $beta
     * @param array $openTagList
     * @param string|null $url
     *
     * @return array|string
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws RuntimeException
     * @throws GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getAgentConfigArray(
        array  $apis,
               $agentId,
        bool   $debug = false,
        bool   $beta = false,
        array  $openTagList = [],
        string $url = null
    )
    {
        return $this->buildAgentConfig($apis, $agentId, $debug, $beta, false, $openTagList, $url);
    }

    /**
     * Get agent config json for jsapi.
     *
     * @param array $jsApiList
     * @param int|string $agentId
     * @param bool $debug
     * @param bool $beta
     * @param bool $json
     * @param array $openTagList
     * @param string|null $url
     *
     * @return array|string
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws RuntimeException
     * @throws GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function buildAgentConfig(
        array  $jsApiList,
               $agentId,
        bool   $debug = false,
        bool   $beta = false,
        bool   $json = true,
        array  $openTagList = [],
        string $url = null
    )
    {
        $config = array_merge(compact('debug', 'beta', 'jsApiList', 'openTagList'), $this->agentConfigSignature($agentId, $url));

        return $json ? json_encode($config) : $config;
    }


    /**
     * Sign the params.
     *
     * @param string $ticket
     * @param string $nonce
     * @param int $timestamp
     * @param string $url
     *
     * @return string
     */
    public function getTicketSignature(string $ticket, string $nonce, int $timestamp, string $url): string
    {
        return sha1(sprintf('jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s', $ticket, $nonce, $timestamp, $url));
    }

    /**
     * Get js ticket.
     *
     * @param bool $refresh
     * @param string $type
     *
     * @return array
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws RuntimeException
     * @throws GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getTicket(bool $refresh = false, string $type = 'config'): array
    {
        $cacheKey = sprintf('WorkWechatSdk.work.jssdk.ticket.%s.%s', $type, $this->getAppId());

        if (!$refresh && $this->getCache()->has($cacheKey)) {
            return $this->getCache()->get($cacheKey);
        }

        /** @var array<string, mixed> $result */
        $result = $this->castResponseToType(
            $this->requestRaw($this->ticketEndpoint, 'GET'),
            'array'
        );

        $this->getCache()->set($cacheKey, $result, $result['expires_in'] - 500);

        if (!$this->getCache()->has($cacheKey)) {
            throw new RuntimeException('Failed to cache jssdk ticket.');
        }

        return $result;
    }

    /**
     * @param int $agentId
     * @param bool $refresh
     * @param string $type
     *
     * @return array|Collection|mixed|object|ResponseInterface|string
     *
     * @throws InvalidConfigException
     * @throws RuntimeException
     * @throws GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getAgentTicket($agentId, bool $refresh = false, string $type = 'agent_config')
    {
        $cacheKey = sprintf('WorkWechatSdk.work.jssdk.ticket.%s.%s.%s', $agentId, $type, $this->getAppId());

        if (!$refresh && $this->getCache()->has($cacheKey)) {
            return $this->getCache()->get($cacheKey);
        }

        /** @var array<string, mixed> $result */
        $result = $this->castResponseToType(
            $this->requestRaw('cgi-bin/ticket/get', 'GET', ['query' => ['type' => $type]]),
            'array'
        );

        $this->getCache()->set($cacheKey, $result, $result['expires_in'] - 500);

        if (!$this->getCache()->has($cacheKey)) {
            throw new RuntimeException('Failed to cache jssdk ticket.');
        }

        return $result;
    }
}