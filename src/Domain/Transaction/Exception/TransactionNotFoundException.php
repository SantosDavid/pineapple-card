<?php

namespace PineappleCard\Domain\Transaction\Exception;

use PineappleCard\Domain\Shared\Exception\BaseException;
use PineappleCard\Domain\Transaction\TransactionId;

class TransactionNotFoundException extends BaseException
{
    public function __construct(TransactionId $transactionId)
    {
        parent::__construct("Transaction {$transactionId->id()} not founded");
    }
}
