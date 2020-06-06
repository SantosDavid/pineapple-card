<?php

namespace PineappleCard\Domain\Invoice;

use Carbon\Carbon;
use DateTime;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Invoice\Exception\InvoiceOpenedCannotBePaidException;

class Invoice
{
    private const DAYS_CLOSED_BEFORE_DUE_DATE = 10;

    private InvoiceId $invoiceId;

    private CustomerId $customerId;

    private PayDay $payDay;

    private DateTime $createdAt;

    private bool $paid;

    public function __construct(
        InvoiceId $invoiceId,
        CustomerId $customerId,
        PayDay $payDay,
        DateTime $createdAt = null,
        bool $paid = false
    ) {
        $this->invoiceId = $invoiceId;
        $this->customerId = $customerId;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->payDay = $payDay;
        $this->paid = $paid;
    }

    public function id(): InvoiceId
    {
        return $this->invoiceId;
    }

    public function isOpened(): bool
    {
        $now = Carbon::now();

        if ($this->isBeforeInvoiceBeCreated($now, $this->createdAt)) {
            return false;
        }

        return $this->closedAt() >= $now;
    }

    private function isBeforeInvoiceBeCreated(DateTime $now, DateTime $validAt): bool
    {
        return $now < $validAt;
    }

    private function closedAt(): Carbon
    {
        $closedAt = Carbon::instance($this->createdAt);
        $closeDay = $this->payDay->day() - self::DAYS_CLOSED_BEFORE_DUE_DATE;

        if ($closeDay <= $closedAt->format('d')) {
            $closedAt->addMonth();
        }

        $validDay = $closeDay - 1;

        $closedAt->setDay($validDay);

        return $closedAt;
    }

    public function dueDate()
    {
        return $this->closedAt()->addDay(self::DAYS_CLOSED_BEFORE_DUE_DATE + 1);
    }

    public function customerId(): CustomerId
    {
        return $this->customerId;
    }

    public function markAsPayed()
    {
        if ($this->isOpened()) {
            throw new InvoiceOpenedCannotBePaidException($this->id());
        }

        $this->paid = true;
    }

    public function status(): string
    {
        if ($this->isOpened()) {
            return 'opened';
        }

        if ($this->isPaid()) {
            return 'paid';
        }

        return 'pending';
    }

    public function isPaid(): bool
    {
        return $this->paid;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function payDay(): PayDay
    {
        return $this->payDay;
    }
}
