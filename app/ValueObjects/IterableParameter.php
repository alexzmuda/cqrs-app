<?php

declare(strict_types=1);

namespace App\ValueObjects\Parameters;

use App\Exceptions\InvalidParameterException;
use Illuminate\Support\Collection;

final class IterableParameter extends AbstractParameter
{
    /**
     * @see IterableParameter::getValue() explains reasoning behind <mixed> type hint
     * @var iterable<mixed>|null
     */
    private ?iterable $value;

    /**
     * IterableParameter constructor.
     * @param iterable<mixed> $value
     * @throws InvalidParameterException
     */
    public function __construct(iterable $value)
    {
        parent::__construct($this->isNullable);
        $this->assertCompliance($value);
        $this->value = $value;
    }

    public static function getType(): string
    {
        return 'collection';
    }

    /**
     * @description Due to lack of proper typing in PHP `mixed` is forced as a type hint in iterable
     * what you must expect here is a general array|list|dictionary that was sent within an input or null
     * depending of initial configuration of the instance
     * @see IterableParameter::__construct()
     *
     * @return iterable<mixed>|null
     */
    public function getValue(): ?iterable
    {
        return $this->value;
    }

    /**
     * @description Collection<mixed> is unfortunately a must due to lack of generic values in PHP
     * generally the idea behind it is that whatever iterable value is under $this->value will be
     * converted into Laravel Collection
     *
     * @return Collection<mixed>
     */
    public function toCollection(): Collection
    {
        return collect($this->value);
    }
}
