<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use PineappleCard\Application\Card\Create\CreateCardRequest;
use PineappleCard\Application\Card\Create\CreateCardService;
use PineappleCard\Domain\Shared\Exception\BaseException;

class CardController extends Controller
{
    private CreateCardService $service;

    public function __construct(CreateCardService $service)
    {
        $this->service = $service;
    }

    public function store()
    {
        try {
            $applicationRequest = (new CreateCardRequest())
                ->setCustomerId(auth()->user()->id());

            $response = $this->service->execute($applicationRequest);

            return $this->response->created(null, $response);
        } catch (BaseException $exception) {
            $this->response->errorBadRequest($exception->getMessage());
        }
    }
}
