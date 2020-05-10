<?php

namespace PineappleCard\Application\Customer\Create;

class CreateCustomerRequest
{
    private int $payDay;

    private float $limit;

    public function getPayDay(): int
    {
        return $this->payDay;
    }

    public function setPayDay(int $payDay): CreateCustomerRequest
    {
        $this->payDay = $payDay;

        return $this;
    }

    public function getLimit(): float
    {
        return $this->limit;
    }

    public function setLimit(float $limit): CreateCustomerRequest
    {
        $this->limit = $limit;

        return $this;
    }
}
