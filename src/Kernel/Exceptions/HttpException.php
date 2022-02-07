<?php


namespace WorkWechatSdk\Kernel\Exceptions;

use WorkWechatSdk\Kernel\Support\Collection;
use Psr\Http\Message\ResponseInterface;

/**
 * Http异常
 *
 */
class HttpException extends Exception
{
    /**
     * @var ResponseInterface|null
     */
    public $response;

    /**
     * @var ResponseInterface|Collection|array|object|string|null
     */
    public $formattedResponse;

    /**
     * HttpException constructor.
     *
     * @param string $message
     * @param ResponseInterface|null $response
     * @param null $formattedResponse
     * @param int|null $code
     */
    public function __construct($message, ResponseInterface $response = null, $formattedResponse = null, int $code = null)
    {
        parent::__construct($message, $code);

        $this->response = $response;
        $this->formattedResponse = $formattedResponse;
        if ($response) {
            $response->getBody()->rewind();
        }
    }
}