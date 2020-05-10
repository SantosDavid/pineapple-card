<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\CustomerRepository;

class DoctrineCustomerRepository extends EntityRepository implements CustomerRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Customer::class));
    }

    public function create(Customer $customer): Customer
    {
        $em = $this->getEntityManager();

        $em->persist($customer);

        $em->flush();

        return $customer;
    }

    public function byId(CustomerId $customerId): ?Customer
    {
        return $this->find($customerId->id());
    }
}
