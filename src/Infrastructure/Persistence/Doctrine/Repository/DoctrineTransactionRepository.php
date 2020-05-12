<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionRepository;

class DoctrineTransactionRepository extends DoctrineRepository implements TransactionRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Transaction::class));
    }

    public function save(Transaction $transaction): Transaction
    {
        $this->store($transaction);

        return $transaction;
    }
}
