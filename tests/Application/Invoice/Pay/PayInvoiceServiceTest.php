<?php

namespace Tests\Application\Invoice\Pay;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Invoice\Pay\PayInvoiceRequest;
use PineappleCard\Application\Invoice\Pay\PayInvoiceService;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Invoice\Exception\InvoiceNotFoundException;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Infrastructure\Persistence\InMemory\InvoiceInMemoryRepository;

class PayInvoiceServiceTest extends TestCase
{
    private InvoiceInMemoryRepository $invoiceRepository;

    private PayInvoiceService $service;

    public function setUp(): void
    {
        $this->invoiceRepository = new InvoiceInMemoryRepository();

        $this->service = new PayInvoiceService($this->invoiceRepository);
    }

    public function testShouldRaiseExceptionWhenInvoiceIsNotFound()
    {
        $this->expectException(InvoiceNotFoundException::class);

        $request = (new PayInvoiceRequest())
            ->setCustomerId(1)
            ->setInvoiceId(1);


        $this->service->execute($request);
    }

    public function testShouldUpdateInvoiceStatus()
    {
        $customerId = new CustomerId();
        $invoiceId = new InvoiceId();

        $createdAt = Carbon::create(2020, 1, 1);
        Carbon::setTestNow(Carbon::create(2020, 2, 3));

        $this->invoiceRepository->create($invoice = new Invoice($invoiceId, $customerId, new PayDay(15)), $createdAt);

        $request = (new PayInvoiceRequest())
            ->setInvoiceId($invoice->id())
            ->setCustomerId($customerId->id());


        $this->service->execute($request);


        $this->assertTrue($invoice->isPaid());
    }
}
