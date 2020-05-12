<?php

namespace Tests\Application\Invoice\FindOrCreate;

use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceRequest;
use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceService;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Invoice\ValueObject\Period;
use PineappleCard\Domain\Invoice\ValueObject\Status;

class FindOrCreateInvoiceServiceTest extends TestCase
{
    private FakeInvoiceRepository $invoiceRepository;

    private FindOrCreateInvoiceService $service;

    public function setUp(): void
    {
        $this->invoiceRepository = new FakeInvoiceRepository();

        $this->service = new FindOrCreateInvoiceService(
            $this->invoiceRepository
        );
    }

    public function testShouldNotCreateWhenFindByPeriod()
    {
        FakeInvoiceRepository::$byPeriod = new Invoice(
            new InvoiceId(),
            new CustomerId(),
            new Period(1, 2000),
            new Status()
        );

        $request = (new FindOrCreateInvoiceRequest())
            ->setCustomerId(1)
            ->setMonth(1)
            ->setYear(1);


        $this->service->execute($request);


        $this->assertFalse(FakeInvoiceRepository::$createdCalled);
    }

    public function testShouldCreateWhenNotFindByPeriod()
    {
        FakeInvoiceRepository::$byPeriod = null;

        $request = (new FindOrCreateInvoiceRequest())
            ->setCustomerId(1)
            ->setMonth(1)
            ->setYear(1);


        $this->service->execute($request);


        $this->assertTrue(FakeInvoiceRepository::$createdCalled);
    }
}
