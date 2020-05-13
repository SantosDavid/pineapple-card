<?php

namespace Tests\Infrastructure\UI\Laravel;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Customer\ValueObject\PayDay;
use PineappleCard\Domain\Shared\ValueObject\Auth;
use PineappleCard\Domain\Shared\ValueObject\Money;
use PineappleCard\Infrastructure\UI\Laravel\Auth\Customer\CustomerAuth;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function assertDatabaseHasId($table, $id)
    {
        $em = app(EntityManagerInterface::class);

        $this->assertNotNull($em->find($table, $id));
    }

    public function actingAsCustomer(): Customer
    {
        $customerRepository = app(CustomerRepository::class);

        $customer = $customerRepository->create((new Customer(
            new CustomerId(1),
            new PayDay(10),
            new Money(1000),
            new Auth('daviddsantosd@gmail.com', '123456')
        )));

        $token = JWTAuth::fromUser(new CustomerAuth($customer));
        $this->withHeader('Authorization', 'Bearer ' . $token);

        return $customer;
    }
}
