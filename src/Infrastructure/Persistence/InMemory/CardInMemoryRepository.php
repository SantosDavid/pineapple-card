<?php

namespace PineappleCard\Infrastructure\Persistence\InMemory;

use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Card\CardRepository;
use PineappleCard\Domain\Customer\CustomerId;
use Tightenco\Collect\Support\Collection;

class CardInMemoryRepository implements CardRepository
{
    private Collection $itens;

    public function __construct()
    {
        $this->itens = new Collection();
    }

    public function create(Card $card): Card
    {
        $this->itens->push($card);

        return $card;
    }

    public function countItems(): int
    {
        return $this->itens->count();
    }

    public function byId(CardId $cardId): ?Card
    {
        return $this->itens->first(fn (Card $card) => $card->id()->equals($cardId));
    }

    public function byCustomerId(CustomerId $customerId): Collection
    {
        return $this->itens->filter(fn (Card $card) => $card->customerId()->equals($customerId));
    }
}
