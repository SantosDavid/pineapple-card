<?php

namespace PineappleCard\Application\Card\Create;

use PineappleCard\Domain\Card\CardId;

class CreateCardResponse
{
    private CardId $cardId;

    public function __construct(CardId $cardId)
    {
        $this->cardId = $cardId;
    }

    public function __toString()
    {
        return json_encode(['id' => $this->cardId->id()]);
    }
}
