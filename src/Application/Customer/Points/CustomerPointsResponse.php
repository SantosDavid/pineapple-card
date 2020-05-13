<?php

namespace PineappleCard\Application\Customer\Points;

class CustomerPointsResponse
{
    private float $points;

    public function __construct(float $points)
    {
        $this->points = $points;
    }

    public function getPoints(): float
    {
        return $this->points;
    }

    public function __toString()
    {
        return json_encode([
            'points' => $this->points,
        ]);
    }
}
