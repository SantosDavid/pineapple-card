<?php

namespace PineappleCard\Application\Invoice\FindOrCreate;

use PineappleCard\Domain\Card\CardId;
use PineappleCard\Domain\Invoice\Invoice;
use PineappleCard\Domain\Invoice\InvoiceId;
use PineappleCard\Domain\Invoice\InvoiceRepository;
use PineappleCard\Domain\Invoice\ValueObject\Period;
use PineappleCard\Domain\Invoice\ValueObject\Status;

class FindOrCreateInvoiceService
{
    private InvoiceRepository $repository;

    public function __construct(InvoiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(FindOrCreateInvoiceRequest $request)
    {
        $invoice = $this->repository->byPeriod(
            $cardId = new CardId($request->getCardId()),
            $period = new Period($request->getMonth(), $request->getYear())
        );

        if (is_null($invoice)) {
            $invoice = $this->repository->create(
                new Invoice(new InvoiceId(), $cardId, $period, new Status())
            );
        }

        return new FindOrCreateInvoiceResponse($invoice->id());
    }
}
