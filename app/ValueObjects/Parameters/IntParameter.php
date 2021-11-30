<?php

declare(strict_types=1);

namespace App\ValueObjects\Parameters;

use App\Exceptions\InvalidParameterException;

final class IntParameter extends AbstractParameter
{
    private ?int $value;

    /**
     * @param int|null $value
     * @param bool $isNullable
     * @throws InvalidParameterException
     */
    public function __construct(?int $value, bool $isNullable = false)
    {
        parent::__construct($isNullable);
        $this->assertCompliance($value);
        $this->value = $value;
    }

    public static function getType(): string
    {
        return 'integer';
    }

    public function getValue(): ?int
    {
        return $this->value;
    }
}
