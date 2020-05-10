<?php

namespace PineappleCard\Domain\Shared\ValueObject;

use PineappleCard\Domain\Shared\Exception\InvalidEmailException;

class Auth
{
    private string $email;

    private string $password;

    public function __construct(string $email, string $encodedPassword)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($email);
        }

        $this->email = $email;
        $this->password = $encodedPassword;
    }
}
