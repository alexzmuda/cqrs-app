<?php

declare(strict_types=1);

namespace App\ValueObjects\Parameters;

use App\Exceptions\InvalidParameterException;

final class BoolParameter extends AbstractParameter
{
    private ?bool $value;

    /**
     * @param bool|null $value
     * @param bool $isNullable
     * @throws InvalidParameterException
     */
    public function __construct(?bool $value, bool $isNullable = false)
    {
        parent::__construct($isNullable);
        $this->assertCompliance($value);
        $this->value = $value;
    }

    public static function getType(): string
    {
        return 'boolean';
    }

    public function getValue(): ?bool
    {
        return $this->value;
    }
}
