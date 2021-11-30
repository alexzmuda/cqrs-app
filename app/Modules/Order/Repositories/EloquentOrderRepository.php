<?php

namespace App\Modules\Order\Repositories;

use App\Modules\Order\Exceptions\OrderNotFoundException;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Repositories\Interfaces\OrderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

final class EloquentOrderRepository implements OrderRepository
{
    public function index(): Collection
    {
        return Order::query()->get();
    }


    public function store(Order $order): void
    {
        $order->save();
    }

    public function findById(int $orderId): Order
    {
        /** @var Order|null $order */
        $order = Order::query()
            ->find($orderId);

        if ($order === null) {
            throw new OrderNotFoundException($orderId);
        }

        return $order;
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }
} 