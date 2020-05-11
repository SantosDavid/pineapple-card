<?php

namespace PineappleCard\Domain\Card;

use Ramsey\Uuid\Uuid;

class CardId
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

    public function equals(CardId $cardId): bool
    {
        return $this->id === $cardId->id;
    }

    public function __toString()
    {
        return $this->id;
    }
}
