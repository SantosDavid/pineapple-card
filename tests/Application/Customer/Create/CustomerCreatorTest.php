<?php

namespace Tests\Application\Customer\Create;

use PineappleCard\Application\Customer\Create\CustomerCreator;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\ValueObject\Money;
use PineappleCard\Infrastructure\Persistence\InMemory\CustomerInMemoryRepository;
use PHPUnit\Framework\TestCase;

class CustomerCreatorTest extends TestCase
{
    private CustomerInMemoryRepository $repository;

    private CustomerCreator $creator;

    public function setUp(): void
    {
        $this->repository = new CustomerInMemoryRepository();
        $this->creator = new CustomerCreator($this->repository);
    }

    public function testShouldCreateCustomer()
    {
        $this->creator->execute(
            new PayDay(5),
            new Money(100),
        );


        $this->assertEquals(1, $this->repository->totalItens());
    }
}
