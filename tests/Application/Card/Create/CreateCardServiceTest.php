<?php

namespace Tests\Application\Card\Create;

use PHPUnit\Framework\TestCase;
use PineappleCard\Application\Card\Create\CreateCardRequest;
use PineappleCard\Application\Card\Create\CreateCardService;
use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\Exception\CustomerIdNotExistsException;
use PineappleCard\Domain\Shared\ValueObject\Auth;
use PineappleCard\Domain\Shared\ValueObject\Money;
use PineappleCard\Infrastructure\Persistence\InMemory\CardInMemoryRepository;
use PineappleCard\Infrastructure\Persistence\InMemory\CustomerInMemoryRepository;

class CreateCardServiceTest extends TestCase
{
    private CustomerInMemoryRepository $customerRepository;

    private CardInMemoryRepository $cardRepository;

    private CreateCardService $service;

    public function setUp(): void
    {
        $this->customerRepository = new CustomerInMemoryRepository();
        $this->cardRepository = new CardInMemoryRepository();

        $this->service = new CreateCardService(
            $this->customerRepository,
            $this->cardRepository
        );
    }

    public function testShouldRaiseExceptionWhenCustomerIdDoNotExists()
    {
        $this->expectException(CustomerIdNotExistsException::class);


        $request = (new CreateCardRequest())->setCustomerId('1');


        $this->service->execute($request);
    }

    public function testShouldCreateCard()
    {
        $customer = (new Customer(
            new CustomerId(1),
            new PayDay(10),
            new Money(1),
            new Auth('daviddsantosd@gmail.com', '123456')
        ));

        $this->customerRepository->create($customer);

        $request = (new CreateCardRequest())->setCustomerId($customer->id()->id());


        $this->service->execute($request);


        $this->assertEquals(1,  $this->cardRepository->countItems());
    }
}
