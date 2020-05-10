<?php

namespace PineappleCard\Application\Customer\Create;

class CreateCustomerRequest
{
    private int $payDay;

    private float $limit;

    private string $email;

    private string $encodedPassword;

    public function getPayDay(): int
    {
        return $this->payDay;
    }

    public function setPayDay(int $payDay): CreateCustomerRequest
    {
        $this->payDay = $payDay;

        return $this;
    }

    public function getLimit(): float
    {
        return $this->limit;
    }

    public function setLimit(float $limit): CreateCustomerRequest
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CreateCustomerRequest
     */
    public function setEmail(string $email): CreateCustomerRequest
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEncodedPassword(): string
    {
        return $this->encodedPassword;
    }

    /**
     * @param string $encodedPassword
     * @return CreateCustomerRequest
     */
    public function setEncodedPassword(string $encodedPassword): CreateCustomerRequest
    {
        $this->encodedPassword = $encodedPassword;
        return $this;
    }
}
