<?php

namespace PineappleCard\Application\Invoice\FindOrCreate;

class FindOrCreateInvoiceRequest
{
    private int $month;

    private int $year;

    private string $customerId;

    public function getMonth(): int
    {
        return $this->month;
    }

    public function setMonth(int $month): FindOrCreateInvoiceRequest
    {
        $this->month = $month;
        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): FindOrCreateInvoiceRequest
    {
        $this->year = $year;
        return $this;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): FindOrCreateInvoiceRequest
    {
        $this->customerId = $customerId;
        return $this;
    }
}
