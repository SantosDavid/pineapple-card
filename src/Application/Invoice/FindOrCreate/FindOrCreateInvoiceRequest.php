<?php

namespace PineappleCard\Application\Invoice\FindOrCreate;

class FindOrCreateInvoiceRequest
{
    private string $cardId;

    private int $month;

    private int $year;

    public function getCardId(): string
    {
        return $this->cardId;
    }

    public function setCardId(string $cardId): FindOrCreateInvoiceRequest
    {
        $this->cardId = $cardId;
        return $this;
    }

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
}
