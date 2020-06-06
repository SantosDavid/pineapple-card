<?php

namespace PineappleCard\Infrastructure\Persistence\MongoDB;

use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Shared\ValueObject\Geolocation;
use PineappleCard\Domain\Shared\ValueObject\Money;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionId;
use PineappleCard\Domain\Transaction\TransactionRepository;
use PineappleCard\Domain\Transaction\ValueObject\Establishment;
use Tightenco\Collect\Support\Collection;

class MongoDBTransactionRepository extends MongoDBRepository implements TransactionRepository
{
    public function create(Transaction $transaction): Transaction
    {
        $this->collection->insertOne($this->toJson($transaction));

        return $transaction;
    }

    public function save(Transaction $transaction)
    {
        $this->collection->replaceOne(['id' => $transaction->id()], $this->toJson($transaction));
    }

    public function byId(TransactionId $transactionId): ?Transaction
    {
        if (is_null($transaction = $this->collection->findOne(['id' => $transactionId->id()]))) {
            return null;
        }

        return $this->fromJson($transaction);
    }

    public function byInvoicesId(Collection $invoicesId): Collection
    {
        $ids = $invoicesId
            ->map(fn(InvoiceId $invoiceId) => $invoiceId->id())
            ->flatten()
            ->toArray();

        $collection = $this->collection->find(['invoice_id' => ['$in' => $ids]])->toArray();

        return (new Collection($collection))
            ->map(fn(object $data) => $this->fromJson($data));
    }

    protected function collectionName(): string
    {
        return 'transactions';
    }

    private function toJson(Transaction $transaction): object
    {
        return json_decode(json_encode([
            'id' => $transaction->id()->id(),
            'invoice_id' => $transaction->invoiceId()->id(),
            'card_id' => $transaction->cardId()->id(),
            'establishment' => [
                'name' => $transaction->establishment()->name(),
                'category' => $transaction->establishment()->category(),
                'geolocation' => [
                    'latitude' => $transaction->establishment()->geoLocation()->latitude(),
                    'longitude' => $transaction->establishment()->geoLocation()->longitude(),
                ]
            ],
            'value' => [
                'amount' => $transaction->value()->amount(),
                'currency' => $transaction->value()->currency(),
            ],
            'created_at' => $transaction->createdAt()->format('c'),
        ]));
    }

    private function fromJson(object $data): Transaction
    {
        $geolocation = new Geolocation(
            $data->establishment->geolocation->latitude,
            $data->establishment->geolocation->longitude
        );

        return new Transaction(
            new TransactionId($data->id),
            new InvoiceId($data->invoice_id),
            new CardId($data->card_id),
            new Establishment($data->establishment->name, $data->establishment->category, $geolocation),
            new Money($data->value->amount, $data->value->currency),
            new \DateTime($data->created_at)
        );
    }
}
