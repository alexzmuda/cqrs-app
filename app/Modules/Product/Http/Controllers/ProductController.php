<?php

namespace App\Modules\Product\Http\Controllers;

use App\Exceptions\InvalidParameterException;
use App\Infrastructure\CQRS\CommandRegistry;
use App\Infrastructure\CQRS\QueryRegistry;
use App\Infrastructure\Exceptions\InvalidFormRequestException;
use App\Modules\Product\Exceptions\ProductNotFoundException;
use App\Modules\Product\Http\Requests\UpdateProductRequest;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Services\CQRS\CommandFactories\UpdateProductCommandFactory;
use App\Modules\Product\Services\CQRS\Queries\FetchProductByIdQuery;
use App\Modules\Product\Http\Requests\CreateProductRequest;
use App\Modules\Product\Http\Transformers\ProductTransformer;
use App\Modules\Product\Services\CQRS\CommandFactories\CreateProductCommandFactory;
use App\Modules\Product\Services\CQRS\Commands\DestroyProductCommand;
use App\Modules\Product\Services\CQRS\Queries\FetchProductsQuery;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    private CommandRegistry $commandRegistry;
    private QueryRegistry $queryRegistry;


    public function __construct(CommandRegistry $commandRegistry, QueryRegistry $queryRegistry)
    {
        $this->commandRegistry = $commandRegistry;
        $this->queryRegistry = $queryRegistry;
    }

    /**
     * Display a listing of products
     * @return Response
     */
    public function index(): Response
    {
        $orders = $this->queryRegistry
            ->handle(new FetchProductsQuery(
            // Auth::user()->getKey()
            ));

        return response(ProductTransformer::collection($orders))
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param CreateProductRequest $request
     * @return Response
     * @throws InvalidParameterException
     * @throws InvalidFormRequestException
     * @throws ProductNotFoundException
     */
    public function create(CreateProductRequest $request, CreateProductCommandFactory $factory): Response
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


        /** @var Product $order */
        try {
            $order = $this->queryRegistry
                ->handle(new FetchProductByIdQuery($orderId));
        } catch (ProductNotFoundException $e) {
            return response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return response(new ProductTransformer($order), Response::HTTP_CREATED);

        //$policy = Gate::inspect('viewProduct', $order);

        //if ($policy->allowed()) {
        // return response(new ProductTransformer($order), Response::HTTP_CREATED);
        //      } else {
        //        return response($policy->message(), Response::HTTP_FORBIDDEN);
        //  }
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return Response
     * @throws ProductNotFoundException
     */
    public function show(int $id): Response
    {
        /** @var Product $order */
        try {
            $order = $this->queryRegistry
                ->handle(new FetchProductByIdQuery($id));
        } catch (ProductNotFoundException $e) {
            return response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return response(new ProductTransformer($order), Response::HTTP_OK);

        // $policy = Gate::inspect('viewProduct', $order);

        //if ($policy->allowed()) {
        //     return response(new ProductTransformer($order), Response::HTTP_OK);
        // } else {
        //     return response($policy->message(), Response::HTTP_FORBIDDEN);
        // }
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateProductRequest $request
     * @param int $id
     * @return Responsable
     * @throws ProductNotFoundException
     */
    public function update(UpdateProductRequest $request, UpdateProductCommandFactory $factory): Response
    {
        /** @var Product $product */
        try {
            $product = $this->queryRegistry
                ->handle(new FetchProductByIdQuery($request->id));
        } catch (ProductNotFoundException $e) {
            return response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        $policy = Gate::inspect('updateProduct', $product);

        if ($policy->allowed()) {
            $this->commandRegistry
                ->handle($factory->createFromRequest($request));

            return response(
                null,
                Response::HTTP_NO_CONTENT
            );
        } else {
            return response($policy->message(), Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Delete the specified resource from storage.
     * @param int $id
     * @return Response
     * @throws ProductNotFoundException
     */
    public function destroy(int $id)
    {
        /** @var Product $order */
        try {
            $order = $this->queryRegistry
                ->handle(new FetchProductByIdQuery($id));
        } catch (ProductNotFoundException $e) {
            return response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        $policy = Gate::inspect('deleteProduct', $order);

        if ($policy->allowed()) {
            $this->commandRegistry->handle(new DestroyProductCommand($order));
            return response("", Response::HTTP_NO_CONTENT);
        } else {
            return response($policy->message(), Response::HTTP_FORBIDDEN);
        }
    }
}
