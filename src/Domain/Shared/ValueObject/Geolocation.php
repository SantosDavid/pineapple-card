<?php

namespace PineappleCard\Domain\Shared\ValueObject;

class Geolocation
{
    private string $latitude;
    private string $longitude;

    public function __construct(string $latitude, string $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function latitude(): string
    {
        return $this->latitude;
    }

    public function longitude(): string
    {
        return $this->longitude;
    }
}
