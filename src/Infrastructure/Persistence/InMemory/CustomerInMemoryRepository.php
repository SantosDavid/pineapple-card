<?php

namespace PineappleCard\Infrastructure\Persistence\InMemory;

use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerRepository;
use Tightenco\Collect\Support\Collection;

class CustomerInMemoryRepository implements CustomerRepository
{
    private Collection $itens;

    public function __construct()
    {
        $this->itens = new Collection();
    }

    public function create(Customer $customer): Customer
    {
        $this->itens->push($customer);

        return $customer;
    }

    public function totalItens(): int
    {
        return $this->itens->count();
    }
}