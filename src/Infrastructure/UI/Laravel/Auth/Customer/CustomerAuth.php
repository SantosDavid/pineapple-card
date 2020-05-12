<?php

namespace PineappleCard\Infrastructure\UI\Laravel\Auth\Customer;

use Illuminate\Contracts\Auth\Authenticatable;
use PineappleCard\Domain\Customer\Customer;
use PineappleCard\Domain\Customer\CustomerId;
use Tymon\JWTAuth\Contracts\JWTSubject;

class CustomerAuth implements Authenticatable, JWTSubject
{
    /**
     * @var Customer
     */
    private Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function id(): CustomerId
    {
        return $this->customer->id();
    }

    public function getEmail(): string
    {
        return $this->customer->auth()->email();
    }

    public function getAuthIdentifierName()
    {
        return $this->customer->id()->id();
    }

    public function getAuthIdentifier()
    {
        return $this->customer->id()->id();
    }

    public function getAuthPassword()
    {
        return $this->customer->auth()->password();
    }

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }

    public function getJWTIdentifier()
    {
        return $this->getAuthIdentifierName();
    }

    public function getJWTCustomClaims()
    {
        return [

        ];
    }
}
