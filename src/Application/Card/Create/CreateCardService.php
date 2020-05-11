<?php

namespace PineappleCard\Application\Card\Create;

use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Card\CardRepository;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\CustomerRepository;
use PineappleCard\Domain\Shared\Exception\CustomerIdNotExistsException;

class CreateCardService
{
    /**
     * @var CardRepository
     */
    private CardRepository $repository;
    /**
     * @var CustomerRepository
     */
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository, CardRepository $repository)
    {
        $this->repository = $repository;
        $this->customerRepository = $customerRepository;
    }

    public function execute(CreateCardRequest $request)
    {
        $customerId = new CustomerId($request->getCustomerId());

        $this->checkIfCustomerExists($customerId);

        $card = new Card(new CardId(), $customerId);

        $this->repository->create($card);

        return new CreateCardResponse($card->id());
    }

    private function checkIfCustomerExists(CustomerId $customerId): void
    {
        if (is_null($this->customerRepository->byId(new CustomerId($customerId)))) {
            throw new CustomerIdNotExistsException($customerId);
        }
    }
}
