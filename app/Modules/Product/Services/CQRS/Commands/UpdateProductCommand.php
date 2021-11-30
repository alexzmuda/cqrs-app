<?php

declare(strict_types=1);

namespace App\Modules\Product\Services\CQRS\Commands;

use App\Infrastructure\CQRS\Command;
use App\ValueObjects\Parameters\IntParameter;
use App\ValueObjects\Parameters\StringParameter;

final class UpdateProductCommand implements Command
{
    private IntParameter $productId;
    private StringParameter $productName;
    private StringParameter $productCode;
    private StringParameter $productPrice;

    /**
     * UpdateProductCommand constructor.
     *
     * @param int $productId
     */
    public function __construct(
        int    $productId,
        string $productName,
        string $productCode,
        string $productPrice
    )

    {
        $this->productId = new IntParameter($productId);
        $this->productName = new StringParameter($productName);
        $this->productCode = new StringParameter($productCode);
        $this->productPrice = new StringParameter($productPrice);
    }


    public function productId(): IntParameter
    {
        return $this->productId;
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