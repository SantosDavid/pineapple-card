<?php

namespace PineappleCard\Domain\Customer\Exception;

use PineappleCard\Domain\Shared\Exception\BaseException;

class EmailAlreadyExistsException extends BaseException
{
    public function __construct(string $email)
    {
        parent::__construct("The {$email} email is already in use!");
    }
}
