<?php

namespace Tests\Application\Customer\AvailableLimit;

use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Customer\AvailableLimit\AvailableLimitRequest;
use PineappleCard\Application\Customer\AvailableLimit\AvailableLimitService;
use PineappleCard\Infrastructure\Persistence\InMemory\CustomerInMemoryRepository;
use PineappleCard\Infrastructure\Persistence\InMemory\InvoiceInMemoryRepository;
use Tests\Application\Shared\CreateCustomerHelper;
use Tests\Application\Shared\CreateInvoiceHelper;
use Tests\Application\Shared\CreateTransactionHelper;
use Tightenco\Collect\Support\Collection;

class AvailableLimitServiceTest extends TestCase
{
    use CreateCustomerHelper;
    use CreateTransactionHelper;
    use CreateInvoiceHelper;

    private CustomerInMemoryRepository $customerRepository;

    private TransactionRepositoryFake $transactionRepository;

    private AvailableLimitService $service;

    private InvoiceInMemoryRepository $invoiceInMemoryRepository;

    public function setUp(): void
    {
        $this->customerRepository = new CustomerInMemoryRepository();
        $this->transactionRepository = new TransactionRepositoryFake();
        $this->invoiceInMemoryRepository = new InvoiceInMemoryRepository();

        $this->service = new AvailableLimitService(
            $this->customerRepository,
            $this->invoiceInMemoryRepository,
            $this->transactionRepository
        );
    }

    public function testAvailableLimitShouldBeCustomerLimitWhenNotPaidAmountIsZero()
    {
        $customerLimit = 3000;
        $this->customerRepository->create($customer = $this->createCustomer($customerLimit));

        $request = (new AvailableLimitRequest())->setCustomerId($customer->id()->id());


        $response = $this->service->execute($request);


        $this->assertEquals($customerLimit, $response->amount());
    }

    public function testAvailableLimitShouldBeZeroWhenCustomerLimitAndNotPaidAmountAreEquals()
    {
        $customerLimit = 2000;
        $this->customerRepository->create($customer = $this->createCustomer($customerLimit));
        $this->transactionRepository->transactions = new Collection([$this->createTransaction($customerLimit)]);

        $request = (new AvailableLimitRequest())->setCustomerId($customer->id()->id());


        $response = $this->service->execute($request);


        $this->assertEquals(0, $response->amount());
    }

    public function testShouldNotConsiderRefundedTransactions()
    {
        $customerLimit = 200;
        $this->customerRepository->create($customer = $this->createCustomer($customerLimit));
        $this->transactionRepository->transactions = new Collection([
            $this->createTransaction(150),
            $this->createTransaction(120, true),
            $this->createTransaction(200, true),
        ]);

        $request = (new AvailableLimitRequest())->setCustomerId($customer->id()->id());


        $response = $this->service->execute($request);


        $this->assertEquals(50, $response->amount());
    }

    public function testShouldNotConsiderClosedInvoices()
    {
        $this->customerRepository->create($customer = $this->createCustomer());

        $this->invoiceInMemoryRepository->create($invoice1 = $this->createInvoice(true, $customer->id()));
        $this->invoiceInMemoryRepository->create($invoice2 =$this->createInvoice(false, $customer->id()));

        $this->transactionRepository->transactions = new Collection([$this->createTransaction()]);

        $request = (new AvailableLimitRequest())->setCustomerId($customer->id()->id());


        $this->service->execute($request);


        $this->assertEquals(1, $this->transactionRepository->invoicesId->count());
        $this->assertContains($invoice2->id(), $this->transactionRepository->invoicesId);
    }
}
