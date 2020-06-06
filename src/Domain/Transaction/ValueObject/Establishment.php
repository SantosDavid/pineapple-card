<?php

namespace PineappleCard\Domain\Transaction\ValueObject;

use PineappleCard\Domain\Shared\ValueObject\Geolocation;
use PineappleCard\Domain\Transaction\Exception\InvalidEstablishmentCategoryException;

class Establishment
{
    private string $name;

    private int $category;

    private Geolocation $geolocation;

    private float $scoreRate;

    private array $rates = [
        1 => 0.8,
        2 => 1,
        3 => 1.4,
        4 => 1.8,
        5 => 2.3,
        6 => 0.3,
        7 => 2.7,
    ];

    public function __construct(string $name, int $category, Geolocation $geolocation)
    {
        $this->name = $name;
        $this->category = $category;
        $this->geolocation = $geolocation;

        $this->setScoreRate($category);
    }

    private function setScoreRate(int $category)
    {
        if (!array_key_exists($category, $this->rates)) {
            throw new InvalidEstablishmentCategoryException($category);
        }

        $this->scoreRate = $this->rates[$category];
    }

    public function scoreRate(): float
    {
        return $this->scoreRate;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function category(): int
    {
        return $this->category;
    }

    public function geoLocation(): Geolocation
    {
        return $this->geolocation;
    }
}
