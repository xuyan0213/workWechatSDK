<?php


namespace WorkWechatSdk\WeWork\Message;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use WorkWechatSdk\Kernel\Exceptions\InvalidArgumentException;
use WorkWechatSdk\Kernel\Exceptions\InvalidConfigException;
use WorkWechatSdk\Kernel\Exceptions\RuntimeException;
use WorkWechatSdk\Kernel\Messages\Message;
use WorkWechatSdk\Kernel\Messages\Text;
use WorkWechatSdk\Kernel\Support\Arr;
use WorkWechatSdk\Kernel\Support\Collection;


class Messenger
{
    /**
     * @var Message;
     */
    protected $message;

    /**
     * @var array
     */
    protected $to = ['touser' => '@all'];

    /**
     * @var int
     */
    protected $agentId;

    /**
     * @var bool
     */
    protected $secretive = false;

    /**
     * @var Client
     */
    protected $client;

    /**
     * MessageBuilder constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->agentId = 0;
    }

    /**
     * Set message to send.
     *
     * @param string|Message $message
     *
     * @return Messenger
     *
     * @throws InvalidArgumentException
     */
    public function message($message): Messenger
    {
        if (is_string($message) || is_numeric($message)) {
            $message = new Text($message);
        }

        if (!($message instanceof Message)) {
            throw new InvalidArgumentException('消息无效');
        }

        $this->message = $message;

        return $this;
    }

    /**
     * @param int $agentId
     *
     * @return Messenger
     */
    public function ofAgent(int $agentId): Messenger
    {
        $this->agentId = $agentId;

        return $this;
    }

    /**
     * @param array|string $userIds
     *
     * @return Messenger
     */
    public function toUser($userIds): Messenger
    {
        return $this->setRecipients($userIds, 'touser');
    }

    /**
     * @param array|string $partyIds
     *
     * @return Messenger
     */
    public function toParty($partyIds): Messenger
    {
        return $this->setRecipients($partyIds, 'toparty');
    }

    /**
     * @param array|string $tagIds
     *
     * @return Messenger
     */
    public function toTag($tagIds): Messenger
    {
        return $this->setRecipients($tagIds, 'totag');
    }

    /**
     * Keep secret.
     *
     * @return Messenger
     */
    public function secretive(): Messenger
    {
        $this->secretive = true;

        return $this;
    }

    /**
     * verify recipient is '@all' or not
     *
     * @return bool
     */
    protected function isBroadcast(): bool
    {
        return Arr::get($this->to, 'touser') === '@all';
    }

    /**
     * @param array|string $ids
     * @param string $key
     *
     * @return Messenger
     */
    protected function setRecipients($ids, string $key): self
    {
        if (is_array($ids)) {
            $ids = implode('|', $ids);
        }

        $this->to = $this->isBroadcast() ? [$key => $ids] : array_merge($this->to, [$key => $ids]);

        return $this;
    }

    /**
     * @param Message|string|null $message
     *
     * @return array|object|ResponseInterface|string|Collection
     *
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function send($message = null)
    {
        if ($message) {
            $this->message($message);
        }

        if (empty($this->message)) {
            throw new RuntimeException('消息不能为空');
        }

        if (empty($this->agentId)) {
            throw new RuntimeException('未找到指定应用ID');
        }

        $message = $this->message->transformForJsonRequest(array_merge([
            'agentid' => $this->agentId,
            'safe' => intval($this->secretive),
        ], $this->to));

        $this->secretive = false;

        return $this->client->send($message);
    }

    /**
     * Return property.
     *
     * @param string $property
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new InvalidArgumentException(sprintf('未找到"%s"的属性值', $property));
    }
}
