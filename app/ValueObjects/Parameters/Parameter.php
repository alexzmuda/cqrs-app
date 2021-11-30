<?php

namespace App\ValueObjects\Parameters;

interface Parameter
{
    public static function getType(): string;

    /**
     * @return mixed Return type defined in getType()
     * @see self::getType()
     */
    public function getValue();

    public function isNullable(): bool;
}
