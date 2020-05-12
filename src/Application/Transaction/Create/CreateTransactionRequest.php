<?php

namespace PineappleCard\Application\Transaction\Create;

class CreateTransactionRequest
{
    private string $cardId;

    private int $category;

    private string $latitude;

    private string $longitude;

    private float $value;

    private string $invoiceId;

    public function getCardId(): string
    {
        return $this->cardId;
    }

    public function setCardId(string $cardId): CreateTransactionRequest
    {
        $this->cardId = $cardId;
        return $this;
    }

    public function getCategory(): int
    {
        return $this->category;
    }

    public function setCategory(int $category): CreateTransactionRequest
    {
        $this->category = $category;
        return $this;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): CreateTransactionRequest
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): CreateTransactionRequest
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): CreateTransactionRequest
    {
        $this->value = $value;
        return $this;
    }

    public function getInvoiceId(): string
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(string $invoiceId): CreateTransactionRequest
    {
        $this->invoiceId = $invoiceId;
        return $this;
    }
}
