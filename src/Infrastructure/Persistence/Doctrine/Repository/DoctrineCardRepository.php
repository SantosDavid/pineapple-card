<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Card\CardRepository;

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
}
