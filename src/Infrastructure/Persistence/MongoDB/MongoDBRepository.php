<?php

namespace PineappleCard\Infrastructure\Persistence\MongoDB;

use MongoDB\Client;
use MongoDB\Collection;

abstract class MongoDBRepository
{
    protected Collection $collection;

    public function __construct(Client $client)
    {
        $this->collection = $client
            ->selectDatabase('pineapple_card')
            ->selectCollection($this->collectionName());
    }

    abstract protected function collectionName(): string;
}
