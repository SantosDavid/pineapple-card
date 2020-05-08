<?php

namespace PineappleCard\Domain\Customer;

interface CustomerRepository
{
    public function create(Customer $customer): Customer;
}
