<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\CustomerRepository;

class DoctrineCustomerRepository extends DoctrineRepository implements CustomerRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Customer::class));
    }

    public function create(Customer $customer): Customer
    {
        $this->store($customer);

        return $customer;
    }

    public function byId(CustomerId $customerId): ?Customer
    {
        return $this->find($customerId->id());
    }

    public function byEmail(string $email): ?Customer
    {
        return $this->findOneBy(['auth.email' => $email]);
    }
}
