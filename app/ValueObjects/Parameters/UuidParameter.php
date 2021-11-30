<?php

namespace App\ValueObjects\Parameters;

use App\Exceptions\InvalidParameterException;
use App\Exceptions\InvalidUUIDValueException;
use Ramsey\Uuid\Uuid;

class UuidParameter extends AbstractParameter
{
    private string $value;

    /**
     * UuidParameter constructor.
     * @param string|null $value
     * @param bool $isNullable
     * @throws InvalidUUIDValueException
     * @throws InvalidParameterException
     */
    public function __construct(?string $value, bool $isNullable = false)
    {
        parent::__construct($isNullable);
        $this->validate($value);

        $this->value = $value;
    }

    /**
     * @param string|null $value
     * @throws InvalidParameterException
     * @throws InvalidUUIDValueException
     */
    private function validate(?string $value): void
    {
        $this->assertCompliance($value);

        if (null !== $value && !Uuid::isValid($value)) {
            throw new InvalidUUIDValueException($value);
        }
    }

    public static function getType(): string
    {
        return 'uuid';
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
