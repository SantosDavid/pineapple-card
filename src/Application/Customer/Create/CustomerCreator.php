<?php

namespace PineappleCard\Application\Customer\Create;

use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\ValueObject\Money;

class CustomerCreator
{
    private CustomerRepository $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(PayDay $payDay, Money $limit)
    {
        $customer = new Customer(
            new CustomerId(),
            $payDay,
            $limit
        );

        $this->repository->create($customer);
    }
}
