<?php

namespace PineappleCard\Infrastructure\UI\Laravel\Auth\Customer;

use RuntimeException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\CustomerRepository;

class CustomCustomerProvider implements UserProvider
{
    /**
     * @var CustomerRepository
     */
    private CustomerRepository $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function retrieveById($identifier)
    {
        if (is_null($customer = $this->repository->byId(new CustomerId($identifier)))) {
            return null;
        }

        return new CustomerAuth($customer);
    }

    public function retrieveByToken($identifier, $token)
    {
        throw new RuntimeException();
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        throw new RuntimeException();
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (!array_key_exists('email', $credentials) || !array_key_exists('password', $credentials)) {
            return null;
        }

        if (is_null($customer = $this->repository->byEmail($credentials['email']))) {
            return null;
        }

        return new CustomerAuth($customer);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if ($user->getEmail() !== $credentials['email']) {
            return false;
        }

        if (!Hash::check($credentials['password'], $user->getAuthPassword())) {
            return false;
        }

        return true;
    }
}
