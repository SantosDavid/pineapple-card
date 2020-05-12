<?php

namespace PineappleCard\Domain\Card;

use DateTime;
use PineappleCard\Domain\Customer\CustomerId;

class Card
{
    private CardId $cardId;

    private string $number;

    private CustomerId $customerId;

    private DateTime $createdAt;

    public function __construct(CardId $cardId, CustomerId $customerId)
    {
        $this->cardId = $cardId;
        $this->customerId = $customerId;

        $this->number = rand(0000000000000001, 9999999999999999);
        $this->createdAt = new DateTime();
    }

    public function id(): CardId
    {
        return $this->cardId;
    }

    public function customerId(): CustomerId
    {
        return $this->customerId;
    }
}
