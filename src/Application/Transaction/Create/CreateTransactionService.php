<?php

namespace PineappleCard\Application\Transaction\Create;

use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceRequest;
use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceService;
use PineappleCard\Domain\Card\Card;
use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Card\CardRepository;
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

    public function __construct(
        TransactionRepository $repository,
        CardRepository $cardRepository,
        FindOrCreateInvoiceService $findOrCreateInvoiceService
    ) {
        $this->repository = $repository;
        $this->cardRepository = $cardRepository;
        $this->findOrCreateInvoiceService = $findOrCreateInvoiceService;
    }

    public function execute(CreateTransactionRequest $request)
    {
        $cardId = new CardId($request->getCardId());

        $card = $this->findCard($cardId);

        $transaction = $this->createTransaction($request, $card);

        $this->repository->create($transaction);

        return new CreateTransactionResponse($transaction->id());
    }

    private function findCard(CardId $cardId): Card
    {
        if (is_null($card = $this->cardRepository->byId($cardId))) {
            throw new CardIdNotExistsException($cardId);
        }

        return $card;
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
        return new Establishment($request->getCategory(), $this->createGeolocation($request));
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
