<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use Tightenco\Collect\Support\Collection;

class DoctrineInvoiceRepository extends DoctrineRepository implements InvoiceRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Invoice::class));
    }

    public function create(Invoice $invoice): Invoice
    {
        $this->store($invoice);

        return $invoice;
    }

    public function byCustomer(CustomerId $customerId): Collection
    {
        return new Collection($this->createQueryBuilder('i')
            ->where('i.customerId = :customerId')
            ->setParameters([
                'customerId' => $customerId
            ])
            ->getQuery()
            ->getResult());
    }
}
