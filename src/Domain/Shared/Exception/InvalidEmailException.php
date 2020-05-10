<?php

namespace PineappleCard\Domain\Shared\Exception;

class InvalidEmailException extends BaseException
{
    public function __construct(string $email)
    {
        parent::__construct("The {$email} is a valid email");
    }
}
