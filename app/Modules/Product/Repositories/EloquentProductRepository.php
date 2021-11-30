<?php

namespace App\Modules\Product\Repositories;

use App\Modules\Product\Exceptions\ProductNotFoundException;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Repositories\Interfaces\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

final class EloquentProductRepository implements ProductRepository
{
    public function index(): Collection
    {
        return Product::query()->get();
    }


    public function store(Product $product): void
    {
        $product->save();
    }

    public function findById(int $productId): Product
    {
        /** @var Product|null $product */
        $product = Product::query()
            ->find($productId);

        if ($product === null) {
            throw new ProductNotFoundException($productId);
        }

        return $product;
    }

    public function findByCode(string $productCode): Product
    {
        /** @var Product|null $product */
        $product = Product::query()
            ->whereCode($productCode)
            ->first();

        if ($product === null) {
            throw new ProductNotFoundException($productCode);
        }

        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
} 