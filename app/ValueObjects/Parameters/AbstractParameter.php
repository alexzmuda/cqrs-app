<?php

namespace App\ValueObjects\Parameters;

use App\Exceptions\InvalidParameterException;

abstract class AbstractParameter implements Parameter
{
    protected bool $isNullable = false;

    public function __construct(bool $isNullable)
    {
        $this->isNullable = $isNullable;
    }

    protected function assertCompliance($value): void
    {
        if (!$this->isNullable && $value === null) {
            throw new InvalidParameterException(
                InvalidParameterException::NULL_ON_NOT_NULLABLE
            );
        }
    }

    public function isNullable(): bool
    {
        return $this->isNullable;
    }
}
