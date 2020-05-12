<?php

namespace PineappleCard\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository extends EntityRepository
{
    public function store($object)
    {
        $em = $this->getEntityManager();

        $em->persist($object);

        $em->flush();
    }
}
