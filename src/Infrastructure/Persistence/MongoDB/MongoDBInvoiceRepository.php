<?php

namespace PineappleCard\Infrastructure\Persistence\MongoDB;

use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use Tightenco\Collect\Support\Collection;

class MongoDBInvoiceRepository extends MongoDBRepository implements InvoiceRepository
{
    public function create(Invoice $invoice): Invoice
    {
        $this->collection->insertOne($this->toJson($invoice));

        return $invoice;
    }

    public function byCustomer(CustomerId $customerId): Collection
    {
        $collection = $this->collection->find(['customer_id' => $customerId->id()])->toArray();

        return (new Collection($collection))
            ->map(fn (object $data) => $this->fromJson($data));
    }

    public function save(Invoice $invoice)
    {
        $this->collection->replaceOne(['id' => $invoice->id()->id()], $this->toJson($invoice));
    }

    protected function collectionName(): string
    {
        return 'invoices';
    }

    public function toJson(Invoice $invoice)
    {
        return json_decode(json_encode([
            'id' => $invoice->id()->id(),
            'customer_id' => $invoice->customerId()->id(),
            'pay_day' => [
                'day' => $invoice->payDay()->day(),
            ],
            'paid' => $invoice->isPaid(),
            'created_at' => $invoice->createdAt()->format('c'),
        ]));
    }

    public function fromJson(object $data): Invoice
    {
        return new Invoice(
            new InvoiceId($data->id),
            new CustomerId($data->customer_id),
            new PayDay($data->pay_day->day),
            new \DateTime($data->created_at),
            $data->paid
        );
    }
}
