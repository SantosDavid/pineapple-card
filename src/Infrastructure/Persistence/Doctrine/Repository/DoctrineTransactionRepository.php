<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionId;
use PineappleCard\Domain\Transaction\TransactionRepository;
use Tightenco\Collect\Support\Collection;

class DoctrineTransactionRepository extends DoctrineRepository implements TransactionRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Transaction::class));
    }

    public function create(Transaction $transaction): Transaction
    {
        $this->store($transaction);

        return $transaction;
    }

    public function byId(TransactionId $transactionId): ?Transaction
    {
        return $this->find($transactionId);
    }

    public function save(Transaction $transaction)
    {
        $em = $this->getEntityManager();

        $em->flush();
    }
}
