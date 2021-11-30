<?php

namespace App\Modules\Product\Services\CQRS\Commands;

use App\Exceptions\InvalidParameterException;
use App\Infrastructure\CQRS\Command;
use App\Modules\Product\Http\Requests\CreateProductRequest;
use App\ValueObjects\Parameters\IntParameter;
use App\ValueObjects\Parameters\StringParameter;
use Illuminate\Support\Facades\Auth;

final class CreateProductCommand implements Command
{
    private StringParameter $productName;
    private StringParameter $productCode;
    private StringParameter $productPrice;

    /**
     * @param CreateProductRequest $request
     * @throws InvalidParameterException
     */
    public function __construct(
        string $productName,
        string $productCode,
        string $productPrice,
    )

    {
        $this->productName = new StringParameter($productName);
        $this->productCode = new StringParameter($productCode);
        $this->productPrice = new StringParameter($productPrice);
    }

    public function productName(): StringParameter
    {
        return $this->productName;
    }

    public function productCode(): StringParameter
    {
        return $this->productCode;
    }

    public function productPrice(): StringParameter
    {
        return $this->productPrice;
    }
}