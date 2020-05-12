<?php

namespace PineappleCard\Domain\Card;

use PineappleCard\Domain\Shared\Uuid;

class CardId extends Uuid
{
    public function equals(CardId $cardId): bool
    {
        return $this->id === $cardId->id;
    }
}
