<?php

namespace App\Modules\Cart\Http\Controllers;

use App\Infrastructure\CQRS\CommandRegistry;
use App\Modules\Cart\Http\Requests\CartRequest;
use App\Modules\Cart\Http\Transformers\CartTransformer;
use App\Modules\Cart\Services\CQRS\CommandFactories\CartCommandFactory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    private CommandRegistry $commandRegistry;


    public function __construct(CommandRegistry $commandRegistry)
    {
        $this->commandRegistry = $commandRegistry;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    /**
     * Display a listing of the day plans.
     * @return Response
     */

    public function index(CartRequest $request, CartCommandFactory $factory): Response
    {
        $cart = [];
        $cart['checkout']  = $this->commandRegistry
            ->handle($factory->calculate($request));

        return response(new CartTransformer($cart), Response::HTTP_OK);
    }

}
