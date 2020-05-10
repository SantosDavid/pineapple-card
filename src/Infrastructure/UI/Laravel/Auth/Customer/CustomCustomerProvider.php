<?php

namespace PineappleCard\Infrastructure\UI\Laravel\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
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
        return $this->repository->find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        // TODO: Implement retrieveByToken() method.
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (!array_key_exists('email', $credentials) || !array_key_exists('password', $credentials)) {
            return null;
        }

        $a = $this->repository->findAll();

        return $a[0];
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // TODO: Implement validateCredentials() method.
    }
}
