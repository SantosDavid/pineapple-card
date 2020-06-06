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

    public function __construct(CardId $cardId, CustomerId $customerId, int $number = null, DateTime $createdAt = null)
    {
        $this->cardId = $cardId;
        $this->customerId = $customerId;

        $this->number = $number ?? rand(0000000000000001, 9999999999999999);
        $this->createdAt = $createdAt ?? new DateTime();
    }

    public function id(): CardId
    {
        return $this->cardId;
    }

    public function customerId(): CustomerId
    {
        return $this->customerId;
    }

    public function number(): int
    {
        return $this->number;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }
}
