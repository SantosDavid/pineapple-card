<?php

namespace PineappleCard\Domain\Card;

interface CardRepository
{
    public function create(Card $card): Card;
}
