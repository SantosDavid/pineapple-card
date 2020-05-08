<?php

namespace App\Application\Customer\Create;

use App\Domain\Customer\ValueObject\PayDay;
use App\Domain\Shared\ValueObject\Money;

class CreateCustomerHandler
{
    private CustomerCreator $customerCreator;

    public function __construct(CustomerCreator $customerCreator)
    {
        $this->customerCreator = $customerCreator;
    }

    public function __invoke(CreateCustomerCommand $command)
    {
        $this->customerCreator->execute(
            new PayDay($command->getPayDay()),
            new Money($command->getLimit())
        );
    }
}
