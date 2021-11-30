<?php

namespace App\ValueObjects\Parameters;

use App\Exceptions\InvalidParameterException;

final class StringParameter extends AbstractParameter
{
    protected ?string $value;

    /**
     * StringParameter constructor.
     * @param string|null $value
     * @param bool $isNullable
     * @throws InvalidParameterException
     */
    public function __construct(?string $value, bool $isNullable = false)
    {
        parent::__construct($isNullable);
        $this->assertCompliance($value);
        $this->value = $value;
    }

    public static function getType(): string
    {
        return 'string';
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
