<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TransactionRequest;
use PineappleCard\Application\Transaction\Create\CreateTransactionRequest;
use PineappleCard\Application\Transaction\Create\CreateTransactionService;
use PineappleCard\Application\Transaction\Refunded\RefundTransactionRequest;
use PineappleCard\Application\Transaction\Refunded\RefundTransactionService;
use PineappleCard\Domain\Shared\Exception\BaseException;

class TransactionController extends Controller
{
    private CreateTransactionService $service;

    private RefundTransactionService $refundTransactionService;

    public function __construct(CreateTransactionService $service, RefundTransactionService $refundTransactionService)
    {
        $this->service = $service;
        $this->refundTransactionService = $refundTransactionService;
    }

    public function store(TransactionRequest $request)
    {
        try {
            $applicationRequest = (new CreateTransactionRequest())
                ->setCustomerId(auth()->user()->id())
                ->setName($request->get('name'))
                ->setCardId($request->get('card_id'))
                ->setCategory($request->get('category'))
                ->setLatitude($request->get('latitude'))
                ->setLongitude($request->get('longitude'))
                ->setValue($request->get('value'));

            $response = $this->service->execute($applicationRequest);

            return $this->response->created(null, $response);
        } catch (BaseException $exception) {
            $this->response->errorBadRequest($exception->getMessage());
        }
    }

    public function refunded($transactionId)
    {
        try {
            $request = (new RefundTransactionRequest())
                ->setCustomerId(auth()->user()->id())
                ->setTransactionId($transactionId);

            $this->refundTransactionService->execute($request);

            return $this->response->noContent();
        } catch (BaseException $exception) {
            $this->response->errorBadRequest($exception->getMessage());
        }
    }
}
