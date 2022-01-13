<?php
namespace WorkWechatSdk\Kernel\Contracts;

use ArrayAccess;

/**
 * ArrayAble
 */
interface ArrayAble extends ArrayAccess
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array;
}