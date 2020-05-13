<?php

namespace PineappleCard\Application\Transaction\Create;

use PineappleCard\Application\Customer\AvailableLimit\AvailableLimitRequest;
use PineappleCard\Application\Customer\AvailableLimit\AvailableLimitService;
use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceRequest;
use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceService;
use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Card\CardRepository;
use PineappleCard\Domain\Customer\CustomerId;
use PineappleCard\Domain\Customer\Exception\InsufficientLimitException;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Shared\Exception\CardIdNotExistsException;
use PineappleCard\Domain\Shared\ValueObject\Geolocation;
use PineappleCard\Domain\Shared\ValueObject\Money;
use PineappleCard\Domain\Transaction\Transaction;
use PineappleCard\Domain\Transaction\TransactionId;
use PineappleCard\Domain\Transaction\TransactionRepository;
use PineappleCard\Domain\Transaction\ValueObject\Establishment;

class CreateTransactionService
{
    private TransactionRepository $repository;

    private CardRepository $cardRepository;

    private FindOrCreateInvoiceService $findOrCreateInvoiceService;

    private AvailableLimitService $availableLimitService;

    public function __construct(
        TransactionRepository $repository,
        CardRepository $cardRepository,
        FindOrCreateInvoiceService $findOrCreateInvoiceService,
        AvailableLimitService $availableLimitService
    ) {
        $this->repository = $repository;
        $this->cardRepository = $cardRepository;
        $this->findOrCreateInvoiceService = $findOrCreateInvoiceService;
        $this->availableLimitService = $availableLimitService;
    }

    public function execute(CreateTransactionRequest $request)
    {
        $cardId = new CardId($request->getCardId());
        $customerId = new CustomerId($request->getCustomerId());

        $card = $this->findCard($cardId, $customerId);
        $this->checkLimit($customerId,  $request);

        $transaction = $this->createTransaction($request, $card);

        $this->repository->create($transaction);

        return new CreateTransactionResponse($transaction->id());
    }

    private function findCard(CardId $cardId, CustomerId $customerId): Card
    {
        if (is_null($card = $this->cardRepository->byId($cardId))) {
            throw new CardIdNotExistsException($cardId);
        }

        if (!$card->customerId()->equals($customerId)) {
            throw new CardIdNotExistsException($cardId);
        }

        return $card;
    }

    public function checkLimit(CustomerId $customerId, CreateTransactionRequest $request): void
    {
        $limitRequest = (new AvailableLimitRequest)->setCustomerId($customerId->id());

        $response = $this->availableLimitService->execute($limitRequest);

        $limit = new Money($response->amount());

        if ($limit->sub($this->createMoney($request))->amount() < 0) {
            throw new InsufficientLimitException();
        }
    }

    private function createTransaction(CreateTransactionRequest $request, Card $card): Transaction
    {
        return new Transaction(
            new TransactionId(),
            $this->findOrCreateInvoiceId($card),
            $card->id(),
            $this->createEstablishment($request),
            $this->createMoney($request)
        );
    }

    private function findOrCreateInvoiceId(Card $card): InvoiceId
    {
        $request = (new FindOrCreateInvoiceRequest())->setCustomerId($card->customerId());

        return $this->findOrCreateInvoiceService->execute($request)->id();
    }

    private function createEstablishment(CreateTransactionRequest $request): Establishment
    {
        return new Establishment($request->getName(), $request->getCategory(), $this->createGeolocation($request));
    }

    private function createGeolocation(CreateTransactionRequest $request): Geolocation
    {
        return new Geolocation($request->getLatitude(), $request->getLongitude());
    }

    private function createMoney(CreateTransactionRequest $request): Money
    {
        return new Money($request->getValue());
    }
}
