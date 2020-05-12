<?php

namespace Tests\Application\Invoice\FindOrCreate;

use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceRequest;
use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceService;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Infrastructure\Persistence\InMemory\CustomerInMemoryRepository;
use Tests\Application\Shared\CreateCustomerHelper;
use Tightenco\Collect\Support\Collection;

class FindOrCreateInvoiceServiceTest extends TestCase
{
    use CreateCustomerHelper;

    private CustomerInMemoryRepository $customerRepository;

    private FakeInvoiceRepository $invoiceRepository;

    private FindOrCreateInvoiceService $service;

    public function setUp(): void
    {
        $this->invoiceRepository = new FakeInvoiceRepository();
        $this->customerRepository = new CustomerInMemoryRepository();

        $this->service = new FindOrCreateInvoiceService(
            $this->customerRepository,
            $this->invoiceRepository
        );
    }

    public function testShouldNotCreateWhenFindByPeriod()
    {
        $customer = $this->customerRepository->create($this->createCustomer());
        FakeInvoiceRepository::$byCustomer = new Collection([new Invoice(new InvoiceId(), $customer->id(), $customer->payDay())]);

        $request = (new FindOrCreateInvoiceRequest())
            ->setCustomerId($customer->id()->id());


        $this->service->execute($request);


        $this->assertFalse(FakeInvoiceRepository::$createdCalled);
    }

    public function testShouldCreateWhenNotFindByPeriod()
    {
        FakeInvoiceRepository::$byCustomer = null;
        $customer = $this->customerRepository->create($this->createCustomer());

        $request = (new FindOrCreateInvoiceRequest())
            ->setCustomerId($customer->id()->id());


        $this->service->execute($request);


        $this->assertTrue(FakeInvoiceRepository::$createdCalled);
    }
}
