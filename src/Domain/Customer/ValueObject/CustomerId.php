<?php

namespace App\Domain\Customer\ValueObject;

use Ramsey\Uuid\Uuid;

class CustomerId
{
    private string $id;

    public function __construct(string $id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function equals(CustomerId $customerId): bool
    {
        return $this->id === $customerId->id;
    }
}
