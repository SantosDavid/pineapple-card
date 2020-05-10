<?php

namespace Tests\Domain\Customer\ValueObject;

use PHPUnit\Framework\TestCase;
use PineappleCard\Domain\Shared\Exception\InvalidEmailException;
use PineappleCard\Domain\Shared\ValueObject\Auth;

class AuthTest extends TestCase
{
    public function invalidEmailsProvider()
    {
        return [
            ['invalid@email'],
            ['notvalid@@@'],
            ['nome']
        ];
    }

    /**
     * @dataProvider invalidEmailsProvider
     */
    public function testShouldRaiseExceptionWhenEmailIsInvalid(string $email)
    {
        $this->expectException(InvalidEmailException::class);

        new Auth($email, '123456');
    }
}
