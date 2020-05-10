<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PineappleCard\Application\Customer\Create\CreateCustomerRequest;
use PineappleCard\Application\Customer\Create\CreateCustomerService;
use PineappleCard\Domain\Shared\Exception\BaseException;

class CustomerController extends Controller
{
    private CreateCustomerService $service;

    public function __construct(CreateCustomerService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        try {
            $request = (new CreateCustomerRequest())
                ->setPayDay($request->get('pay_day'))
                ->setLimit($request->get('limit'));

            $response = $this->service->execute($request);

            return $this->response->created(null, $response);
        } catch (BaseException $e) {
            $this->response->errorBadRequest($e->getMessage());
        }
    }
}
