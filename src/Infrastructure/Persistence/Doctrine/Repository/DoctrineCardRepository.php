<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Card\CardRepository;

class DoctrineCardRepository extends EntityRepository implements CardRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Card::class));
    }

    public function create(Card $card): Card
    {
        $em = $this->getEntityManager();

        $em->persist($card);

        $em->flush();

        return $card;
    }

    public function byId(CardId $cardId): ?Card
    {
        return $this->find($cardId->id());
    }
}
