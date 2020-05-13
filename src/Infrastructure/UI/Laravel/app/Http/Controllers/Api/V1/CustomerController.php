<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerRequest;
use Illuminate\Support\Facades\Hash;
use PineappleCard\Application\Customer\Create\CreateCustomerRequest;
use PineappleCard\Application\Customer\Create\CreateCustomerService;
use PineappleCard\Application\Customer\Points\CustomerPointsRequest;
use PineappleCard\Application\Customer\Points\CustomerPointsService;
use PineappleCard\Domain\Shared\Exception\BaseException;

class CustomerController extends Controller
{
    private CreateCustomerService $service;

    private CustomerPointsService $customerPointsService;

    public function __construct(CreateCustomerService $service, CustomerPointsService $customerPointsService)
    {
        $this->service = $service;
        $this->customerPointsService = $customerPointsService;
    }

    public function store(CustomerRequest $request)
    {
        try {
            $applicationRequest = (new CreateCustomerRequest())
                ->setPayDay($request->get('pay_day'))
                ->setLimit($request->get('limit'))
                ->setEmail($request->get('email'))
                ->setEncodedPassword(Hash::make($request->get('password')));

            $response = $this->service->execute($applicationRequest);

            return $this->response->created(null, $response);
        } catch (BaseException $e) {
            $this->response->errorBadRequest($e->getMessage());
        }
    }

    public function points()
    {
        try {
            $request = (new CustomerPointsRequest())
                ->setCustomerId(auth()->user()->id());

            $response = $this->customerPointsService->execute($request);

            return $this->response->array($response);
        } catch (BaseException $e) {
            $this->response->errorBadRequest($e->getMessage());
        }
    }
}
