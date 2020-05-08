<?php

namespace App\Domain\Customer;

interface CustomerRepository
{
    public function create(Customer $customer): Customer;
}
