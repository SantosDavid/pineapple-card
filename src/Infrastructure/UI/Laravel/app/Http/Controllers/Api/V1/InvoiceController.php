<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use PineappleCard\Application\Invoice\Overview\OverviewInvoiceRequest;
use PineappleCard\Application\Invoice\Overview\OverviewInvoiceService;
use PineappleCard\Application\Invoice\Pay\PayInvoiceRequest;
use PineappleCard\Application\Invoice\Pay\PayInvoiceService;
use PineappleCard\Domain\Shared\Exception\BaseException;

class InvoiceController extends Controller
{
    private PayInvoiceService $service;

    private OverviewInvoiceService $overviewInvoiceService;

    public function __construct(PayInvoiceService $service, OverviewInvoiceService $overviewInvoiceService)
    {
        $this->service = $service;
        $this->overviewInvoiceService = $overviewInvoiceService;
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

    public function overview()
    {
        $request = (new OverviewInvoiceRequest())
            ->setCustomerId(auth()->user()->id());

        $response = $this->overviewInvoiceService->execute($request);

        return $this->response->array($response);
    }
}
