<?php

namespace PineappleCard\Application\Customer\Create;

use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\Exception\EmailAlreadyExistsException;
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

        $this->checkIfEmailExists($auth);

        $customer = $this->create($payDay, $limit, $auth);

        return $this->response($customer);
    }

    private function checkIfEmailExists(Auth $auth): void
    {
        if ($this->repository->byEmail($auth->email())) {
            throw new EmailAlreadyExistsException($auth->email());
        }
    }

    private function create(PayDay $payDay, Money $limit, Auth $auth): Customer
    {
        $customer = new Customer(
            new CustomerId(),
            $payDay,
            $limit,
            $auth
        );

        return $this->repository->create($customer);
    }

    private function response(Customer $customer): CreateCustomerResponse
    {
        return new CreateCustomerResponse($customer->id());
    }
}
