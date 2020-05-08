<?php

namespace App\Application\Customer\Create;

class CreateCustomerCommand
{
    private int $payDay;

    private float $limit;

    public function getPayDay(): int
    {
        return $this->payDay;
    }

    public function setPayDay(int $payDay): void
    {
        $this->payDay = $payDay;
    }

    public function getLimit(): float
    {
        return $this->limit;
    }

    public function setLimit(float $limit): void
    {
        $this->limit = $limit;
    }
}
