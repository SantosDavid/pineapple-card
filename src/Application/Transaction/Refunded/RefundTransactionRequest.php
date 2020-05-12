<?php

namespace PineappleCard\Application\Transaction\Refunded;

class RefundTransactionRequest
{
    private string $customerId;

    private string $transactionId;

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): RefundTransactionRequest
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): RefundTransactionRequest
    {
        $this->transactionId = $transactionId;
        return $this;
    }
}
