<?php

namespace PineappleCard\Domain\Shared;

abstract class Uuid
{
    protected string $id;

    public function __construct(string $id = null)
    {
        $this->id = $id ?? \Ramsey\Uuid\Uuid::uuid4()->toString();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->id;
    }
}
