<?php

namespace App\Modules\Product\Services\CQRS\Handlers;

use App\Exceptions\QueryInvalidException;
use App\Infrastructure\CQRS\Query;
use App\Infrastructure\CQRS\QueryHandler;
use App\Infrastructure\CQRS\SupportedQueryValidator;
use App\Modules\Product\Exceptions\ProductNotFoundException;
use App\Modules\Product\Repositories\Interfaces\ProductRepository;
use App\Modules\Product\Services\CQRS\Queries\FetchProductByIdQuery;


class FetchProductByIdQueryHandler implements QueryHandler
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function handles(): string
    {
        return FetchProductByIdQuery::class;
    }

    /**
     * @param Query|FetchProductByIdQuery $query
     * @return object
     * @throws QueryInvalidException|ProductNotFoundException
     */
    public function handle(Query $query): object
    {
        (new SupportedQueryValidator($query, $this))();

        return $this->repository
            ->findById($query->getProductId());
    }
} 