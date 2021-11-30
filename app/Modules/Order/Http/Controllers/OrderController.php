<?php

namespace App\Modules\Order\Http\Controllers;

use App\Exceptions\InvalidParameterException;
use App\Infrastructure\CQRS\CommandRegistry;
use App\Infrastructure\CQRS\QueryRegistry;
use App\Infrastructure\Exceptions\InvalidFormRequestException;
use App\Modules\Order\Exceptions\OrderNotFoundException;
use App\Modules\Order\Http\Requests\CreateOrderRequest;
use App\Modules\Order\Http\Transformers\OrderTransformer;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Services\CQRS\CommandFactories\CreateOrderCommandFactory;
use App\Modules\Order\Services\CQRS\CommandFactories\UpdateOrderCommandFactory;
use App\Modules\Order\Services\CQRS\Commands\DestroyOrderCommand;
use App\Modules\Order\Services\CQRS\Queries\FetchOrderByIdQuery;
use App\Modules\Order\Services\CQRS\Queries\FetchOrdersByDomainIdQuery;
use App\Modules\Order\Services\CQRS\Queries\FetchOrdersQuery;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    private CommandRegistry $commandRegistry;
    private QueryRegistry $queryRegistry;


    public function __construct(CommandRegistry $commandRegistry, QueryRegistry $queryRegistry)
    {
        $this->commandRegistry = $commandRegistry;
        $this->queryRegistry = $queryRegistry;
    }

    /**
     * Display a listing of the day plans.
     * @return Response
     */
    public function index(): Response
    {
        $orders = $this->queryRegistry
            ->handle(new FetchOrdersQuery(
                Auth::user()->getKey()
            ));

        return response(OrderTransformer::collection($orders))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param CreateOrderRequest $request
     * @return Response
     * @throws InvalidParameterException
     * @throws InvalidFormRequestException
     * @throws OrderNotFoundException
     */
    public function create(CreateOrderRequest $request, CreateOrderCommandFactory $factory): Response
    {
        try {
            $orderId = $this->commandRegistry
                ->handle($factory->createFromRequest($request));
        } catch (QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1062) {
                return response($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }


        /** @var Order $order */
        try {
            $order = $this->queryRegistry
                ->handle(new FetchOrderByIdQuery($orderId));
        } catch (OrderNotFoundException $e) {
            return response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        $policy = Gate::inspect('viewOrder', $order);

        if ($policy->allowed()) {
            return response(new OrderTransformer($order), Response::HTTP_CREATED);
        } else {
            return response($policy->message(), Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return Response
     * @throws OrderNotFoundException
     */
    public function show(int $id): Response
    {
        /** @var Order $order */
        try {
            $order = $this->queryRegistry
                ->handle(new FetchOrderByIdQuery($id));
        } catch (OrderNotFoundException $e) {
            return response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        $policy = Gate::inspect('viewOrder', $order);

        if ($policy->allowed()) {
            return response(new OrderTransformer($order), Response::HTTP_OK);
        } else {
            return response($policy->message(), Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Delete the specified resource from storage.
     * @param int $id
     * @return Response
     * @throws OrderNotFoundException
     */
    public function destroy(int $id)
    {
        /** @var Order $order */
        try {
            $order = $this->queryRegistry
                ->handle(new FetchOrderByIdQuery($id));
        } catch (OrderNotFoundException $e) {
            return response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        $policy = Gate::inspect('deleteOrder', $order);

        if ($policy->allowed()) {
            $this->commandRegistry->handle(new DestroyOrderCommand($order));
            return response("", Response::HTTP_NO_CONTENT);
        } else {
            return response($policy->message(), Response::HTTP_FORBIDDEN);
        }
    }
}
