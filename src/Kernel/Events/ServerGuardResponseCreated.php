<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WorkWechatSdk\Kernel\Events;

use Symfony\Component\HttpFoundation\Response;


class ServerGuardResponseCreated
{
    /**
     * @var Response
     */
    public $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }
}
