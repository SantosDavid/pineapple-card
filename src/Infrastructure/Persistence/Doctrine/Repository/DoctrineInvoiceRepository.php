<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use PineappleCard\Domain\Invoice\ValueObject\Period;

class DoctrineInvoiceRepository extends EntityRepository implements InvoiceRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Invoice::class));
    }

    public function create(Invoice $invoice): Invoice
    {
        $em = $this->getEntityManager();

        $em->persist($invoice);

        $em->flush();

        return $invoice;
    }

    public function byPeriod(CustomerId $customerId, Period $period): ?Invoice
    {
        return collect($this->createQueryBuilder('i')
            ->where('i.period.month = :month')
            ->andWhere('i.period.year = :year')
            ->andWhere('i.customerId = :customerId')
            ->setParameters([
                'month' => $period->month(),
                'year' => $period->year(),
                'customerId' => $customerId
            ])
            ->getQuery()
            ->getResult())
            ->first();
    }
}
