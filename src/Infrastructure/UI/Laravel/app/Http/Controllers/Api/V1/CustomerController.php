<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PineappleCard\Application\Customer\Create\CreateCustomerCommand;
use PineappleCard\Application\Customer\Create\CreateCustomerHandler;
use PineappleCard\Application\Customer\Create\CustomerCreator;
use PineappleCard\Infrastructure\Persistence\Doctrine\Repository\DoctrineCustomerRepository;

class CustomerController extends Controller
{
    /**
     * @var DoctrineCustomerRepository
     */
    private DoctrineCustomerRepository $repository;

    public function __construct(DoctrineCustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $creator = new CustomerCreator($this->repository);

        $handler = new CreateCustomerHandler($creator);

        $request = (new CreateCustomerCommand())
            ->setPayDay($request->get('pay_day'))
            ->setLimit($request->get('limit'));


        $handler->__invoke($request);

        return new JsonResponse('asdas');
    }
}
