<?php

namespace App\Application\Customer\Create;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerRepository;
use App\Domain\Customer\ValueObject\CustomerId;
use App\Domain\Customer\ValueObject\PayDay;
use App\Domain\Shared\ValueObject\Money;

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
