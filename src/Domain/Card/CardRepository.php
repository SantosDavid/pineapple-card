<?php

namespace PineappleCard\Domain\Card;

interface CardRepository
{
    public function create(Card $card): Card;

    public function byId(CardId $cardId): ?Card;
}
