<?php

namespace PineappleCard\Infrastructure\Persistence\MongoDB;

use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Card\CardRepository;
use PineappleCard\Domain\Customer\CustomerId;
use Tightenco\Collect\Support\Collection;

class MongoDBCardRepository extends MongoDBRepository implements CardRepository
{
    public function create(Card $card): Card
    {
        $this->collection->insertOne($this->toJson($card));

        return $card;
    }

    public function byId(CardId $cardId): ?Card
    {
        if (is_null($card = $this->collection->findOne(['id' => $cardId->id()]))) {
            return null;
        }

        return $this->fromJson($card);
    }

    public function byCustomerId(CustomerId $customerId): Collection
    {
        $collection = $this->collection->find(['customer_id' => $customerId->id()])->toArray();

        return (new Collection($collection))
            ->map(fn (object $data) => $this->fromJson($data));
    }

    protected function collectionName(): string
    {
        return 'cards';
    }

    private function toJson(Card $card): object
    {
        return json_decode(json_encode([
            'id' => $card->id()->id(),
            'customer_id' => $card->customerId()->id(),
            'number' => $card->number(),
            'created_at' => $card->createdAt()->format('c'),
        ]));
    }

    private function fromJson(object $data): Card
    {
        return new Card(
            new CardId($data->id),
            new CustomerId($data->customer_id),
            $data->number,
            new \DateTime($data->created_at)
        );
    }
}
