<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use PineappleCard\Application\Invoice\Pay\PayInvoiceRequest;
use PineappleCard\Application\Invoice\Pay\PayInvoiceService;
use PineappleCard\Domain\Shared\Exception\BaseException;

class InvoiceController extends Controller
{
    private PayInvoiceService $service;

    public function __construct(PayInvoiceService $service)
    {
        $this->service = $service;
    }

    public function pay($invoiceId)
    {
        try {
            $request = (new PayInvoiceRequest())
                ->setCustomerId(auth()->user()->id())
                ->setInvoiceId($invoiceId);

            $this->service->execute($request);

            return $this->response->noContent();
        } catch (BaseException $exception) {
            $this->response->errorBadRequest($exception->getMessage());
        }
    }
}
