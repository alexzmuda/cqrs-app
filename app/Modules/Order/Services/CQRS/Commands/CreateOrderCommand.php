<?php

namespace App\Modules\Order\Services\CQRS\Commands;

use App\Exceptions\InvalidParameterException;
use App\Infrastructure\CQRS\Command;
use App\Modules\Order\Http\Requests\CreateOrderRequest;
use App\ValueObjects\Parameters\IntParameter;
use App\ValueObjects\Parameters\StringParameter;
use Illuminate\Support\Facades\Auth;

final class CreateOrderCommand implements Command
{
    private StringParameter $orderFirstname;
    private StringParameter $orderLastname;
    private StringParameter $orderCodes;
    private StringParameter $orderTotalPrice;

    /**
     * @param CreateOrderRequest $request
     * @throws InvalidParameterException
     */
    public function __construct(
        string $orderFirstname,
        string $orderLastname,
        string $orderCodes,
        string $orderTotalPrice
    )

    {
        $this->orderFirstname = new StringParameter($orderFirstname);
        $this->orderLastname = new StringParameter($orderLastname);
        $this->orderCodes = new StringParameter($orderCodes);
        $this->orderTotalPrice = new StringParameter($orderTotalPrice);
    }

    public function orderFirstname(): StringParameter
    {
        return $this->orderFirstname;
    }

    public function orderLastname(): StringParameter
    {
        return $this->orderLastname;
    }

    public function orderCodes(): StringParameter
    {
        return $this->orderCodes;
    }

    public function orderTotalPrice(): StringParameter
    {
        return $this->orderTotalPrice;
    }

} 