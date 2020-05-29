<?php

namespace PineappleCard\Infrastructure\Persistence\MongoDB;

use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\ValueObject\Auth;
use PineappleCard\Domain\Shared\ValueObject\Money;

class MongoDBCustomerRepository extends MongoDBRepository implements CustomerRepository
{
    public function create(Customer $customer): Customer
    {
        $this->collection->insertOne($this->toJson($customer));

        return $customer;
    }

    public function byId(CustomerId $customerId): ?Customer
    {
        if (is_null($customer = $this->collection->findOne(['id' => $customerId->id()]))) {
            return null;
        }

        return $this->fromJson($customer->jsonSerialize());
    }

    public function byEmail(string $email): ?Customer
    {
        if (is_null($customer = $this->collection->findOne(['auth.email' => $email]))) {
            return null;
        }

        return $this->fromJson($customer->jsonSerialize());
    }

    protected function collectionName(): string
    {
        return 'customers';
    }

    private function toJson(Customer $customer)
    {
        return json_decode(json_encode([
            'id' => $customer->id()->id(),
            'pay_day' => [
                'day' => $customer->payDay()->day(),
            ],
            'limit' => [
                'amount' => $customer->limit()->amount(),
                'currency' => $customer->limit()->currency(),
            ],
            'auth' => [
                'email' => $customer->auth()->email(),
                'password' => $customer->auth()->password(),
            ],
            'created_at' => $customer->createdAt()->format('c'),
        ]));
    }

    private function fromJson(object $data): Customer
    {
        return new Customer(
            new CustomerId($data->id),
            new PayDay($data->pay_day->day),
            new Money($data->limit->amount, $data->limit->currency),
            new Auth($data->auth->email, $data->auth->password),
            new \DateTime($data->created_at)
        );
    }
}
