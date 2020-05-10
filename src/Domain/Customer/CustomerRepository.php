<?php

namespace PineappleCard\Domain\Customer;

interface CustomerRepository
{
    public function create(Customer $customer): Customer;

    public function byId(CustomerId $customerId): ?Customer;

    public function byEmail(string $email): ?Customer;
}
