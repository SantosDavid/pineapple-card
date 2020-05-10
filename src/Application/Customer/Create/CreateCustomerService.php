<?php

namespace PineappleCard\Application\Customer\Create;

use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\ValueObject\Auth;
use PineappleCard\Domain\Shared\ValueObject\Money;

class CreateCustomerService
{
    private CustomerRepository $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateCustomerRequest $request): CreateCustomerResponse
    {
        $payDay = new PayDay($request->getPayDay());
        $limit = new Money($request->getLimit());
        $auth = new Auth($request->getEmail(), $request->getEncodedPassword());

        $customer = new Customer(
            new CustomerId(),
            $payDay,
            $limit,
            $auth
        );

        $this->repository->create($customer);

        return new CreateCustomerResponse($customer->id());
    }
}
