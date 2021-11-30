<?php

declare(strict_types=1);

namespace App\Modules\Cart\Services\CQRS\Handlers;

use App\Exceptions\CommandInvalidException;
use App\Exceptions\InvalidParameterException;
use App\Infrastructure\CQRS\Command;
use App\Infrastructure\CQRS\CommandHandler;
use App\Infrastructure\CQRS\CommandRegistry;
use App\Infrastructure\CQRS\SupportedCommandValidator;
use App\Modules\Product\Repositories\Interfaces\ProductRepository;
use App\Modules\Cart\Services\CQRS\Commands\CartCommand;
use Symfony\Component\HttpFoundation\Response;

final class CartCommandHandler implements CommandHandler
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function handles(): string
    {
        return CartCommand::class;
    }

    /**
     * @param Command|CartCommand $command
     * @param CommandRegistry $registry
     * @return array
     * @throws CommandInvalidException
     * @throws InvalidParameterException
     */
    public function handle(Command $command, CommandRegistry $registry)
    {
        (new SupportedCommandValidator($command, $this))();
        $cart = $command->cart();

        /* Rules
        To incentivise customers to spend more, delivery costs are reduced based on the amount
        spent. Orders under $50 cost $4.95. For orders under $90, delivery costs $2.95. Orders of
        $90 or more have free delivery.
        They are also experimenting with special offers. The initial offer will be “buy one red widget,
        get the second half price”.
        */

        // hardcoded array with products eglible for deal
        $deals = ['R01'];

        $items_value = 0.00;
        $delivery_costs = 0.00;
        $total_price = 0.00;

        $cart_processed = [];

        foreach ($cart as $cartLine) {
            $code = $cartLine['code'];
            $qty = $cartLine['qty'];

            // get product
            $product = $this->repository->findByCode($code);
            $item = [];
            $item['id'] = $product->id;
            $item['name'] = $product->name;
            $item['code'] = $product->code;
            $item['price'] = (float) $product->price;
            $item['qty'] = (int) $qty;

            // consider deals...
            $item['total_price'] = $qty * $product->price;
            $item['final_item_price'] = $qty * $product->price;

            if (in_array($code, $deals)) {
                // deal price
                // check how many doubled items
                $doubled = floor($qty / 2);
                $item['doubled'] = $doubled;
                if ($doubled > 0) {
                    $delta = $qty - $doubled;
                    $item['final_item_price'] = $doubled * ($product->price / 2) + $delta * $product->price;
                } else {
                    $item['final_item_price'] = $qty * $product->price;
                }
            }
            $item['total_price'] = round($item['total_price'], 2);
            $item['final_item_price'] = round($item['final_item_price'], 2);

            $cart_processed['items'][] = $item;
            $items_value += $item['final_item_price'];
        }

        $delivery_costs = $this->calculateDeliveryFee($items_value);

        $cart_processed['items_value'] = $items_value;
        $cart_processed['delivery_costs'] = $delivery_costs;
        $cart_processed['final_price'] = round($items_value + $delivery_costs, 2);
        return $cart_processed;
    }

    private function calculateDeliveryFee($amount)
    {
        if ($amount < 50) {
            return 4.95;
        } else if ($amount >= 50 && $amount < 90) {
            return 2.95;
        }
        return 0.00;
    }
} 