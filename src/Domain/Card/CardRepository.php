<?php

namespace PineappleCard\Domain\Card;

use PineappleCard\Domain\Customer\CustomerId;
use Tightenco\Collect\Support\Collection;

interface CardRepository
{
    public function create(Card $card): Card;

    public function byId(CardId $cardId): ?Card;

    public function byCustomerId(CustomerId $customerId): Collection;
}
