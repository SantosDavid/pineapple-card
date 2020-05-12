<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TransactionRequest;
use PineappleCard\Application\Transaction\Create\CreateTransactionRequest;
use PineappleCard\Application\Transaction\Create\CreateTransactionService;
use PineappleCard\Domain\Shared\Exception\BaseException;

class TransactionController extends Controller
{
    private CreateTransactionService $service;

    public function __construct(CreateTransactionService $service)
    {
        $this->service = $service;
    }

    public function store(TransactionRequest $request)
    {
        try {
            $applicationRequest = (new CreateTransactionRequest())
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
}
