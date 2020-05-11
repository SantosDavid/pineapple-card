<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionRepository;

class DoctrineTransactionRepository extends EntityRepository implements TransactionRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Transaction::class));
    }

    public function save(Transaction $transaction): Transaction
    {
        $em = $this->getEntityManager();

        $em->persist($transaction);

        $em->flush();

        return $transaction;
    }
}
