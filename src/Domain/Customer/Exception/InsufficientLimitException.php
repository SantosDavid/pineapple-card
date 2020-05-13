<?php

namespace PineappleCard\Domain\Customer\Exception;

use PineappleCard\Domain\Shared\Exception\BaseException;

class InsufficientLimitException extends BaseException
{
    public function __contruct()
    {
        parent::__construct("You dont have enough limit for this operation");
    }
}
