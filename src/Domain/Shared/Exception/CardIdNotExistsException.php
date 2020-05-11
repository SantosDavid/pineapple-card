<?php

namespace PineappleCard\Domain\Shared\Exception;

use PineappleCard\Domain\Card\CardId;

class CardIdNotExistsException extends BaseException
{
    public function __construct(CardId $cardId)
    {
        parent::__construct("Card id {$cardId->id()} do not exists");
    }
}
