<?php

namespace PineappleCard\Application\Transaction\Create;

use PineappleCard\Application\Invoice\FindOrCreate\FindOrCreateInvoiceService;
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
    /**
     * @var CardRepository
     */
    private CardRepository $cardRepository;
    /**
     * @var FindOrCreateInvoiceService
     */
    private FindOrCreateInvoiceService $findOrCreateInvoiceService;

    public function __construct(TransactionRepository $repository, CardRepository $cardRepository, FindOrCreateInvoiceService $findOrCreateInvoiceService)
    {
        $this->repository = $repository;
        $this->cardRepository = $cardRepository;
        $this->findOrCreateInvoiceService = $findOrCreateInvoiceService;
    }

    public function execute(CreateTransactionRequest $request)
    {
        $cardId = new CardId($request->getCardId());

        $this->checkIfCreditCardExists($cardId);

        $transaction = new Transaction(
            new TransactionId(),
            new InvoiceId(),
            $cardId,
            $this->createEstablishment($request),
            $this->createMoney($request)
        );

        $this->repository->save($transaction);

        return new CreateTransactionResponse($transaction->id());
    }

    private function checkIfCreditCardExists(CardId $cardId): void
    {
        if (is_null($this->cardRepository->byId($cardId))) {
            throw new CardIdNotExistsException($cardId);
        }
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
