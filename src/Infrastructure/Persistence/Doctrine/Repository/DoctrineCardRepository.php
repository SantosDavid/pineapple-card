<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Card\CardRepository;
use PineappleCard\Domain\Customer\CustomerId;
use Tightenco\Collect\Support\Collection;

class DoctrineCardRepository extends DoctrineRepository implements CardRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Card::class));
    }

    public function create(Card $card): Card
    {
        $this->store($card);

        return $card;
    }

    public function byId(CardId $cardId): ?Card
    {
        return $this->find($cardId->id());
    }

    public function byCustomerId(CustomerId $customerId): Collection
    {
        return new Collection($this->findBy(['customerId' => $customerId]));
    }
}
