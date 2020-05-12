<?php

namespace PineappleCard\Domain\Invoice;

use Carbon\Carbon;
use DateTime;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;

class Invoice
{
    private const DAYS_CLOSED_BEFORE_DUE_DATE = 10;

    private InvoiceId $invoiceId;

    private CustomerId $customerId;

    private PayDay $payDay;

    private int $dueDate;

    private DateTime $createdAt;

    private bool $paid;

    public function __construct(
        InvoiceId $invoiceId,
        CustomerId $customerId,
        PayDay $payDay,
        DateTime $createdAt = null,
        bool $paid = false
    )
    {
        $this->invoiceId = $invoiceId;
        $this->customerId = $customerId;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->payDay = $payDay;
        $this->dueDate = $payDay->day() - self::DAYS_CLOSED_BEFORE_DUE_DATE;
        $this->paid = $paid;
    }

    public function id(): InvoiceId
    {
        return $this->invoiceId;
    }

    public function isOpened(): bool
    {
        $validAt = Carbon::instance($this->createdAt);
        $now = Carbon::now();

        if ($this->isBeforeInvoiceBeCreated($now, $validAt)) {
            return false;
        }

        $this->addMonthToValidAt($validAt);
        $this->changeDayOfValidAt($validAt);

        return $validAt >= $now;
    }

    private function isBeforeInvoiceBeCreated(DateTime $now, DateTime $validAt): bool
    {
        return $now < $validAt;
    }

    private function addMonthToValidAt(Carbon $validAt): void
    {
        if ($this->dueDate <= $validAt->format('d')) {
            $validAt->addMonth();
        }
    }

    private function changeDayOfValidAt(Carbon $validAt): void
    {
        $validDay = $this->dueDate - 1;

        $validAt->setDay($validDay);
    }

    public function customerId(): CustomerId
    {
        return $this->customerId;
    }
}
