<?php

namespace App\Exceptions;

use Throwable;

class InvalidUUIDValueException extends \Exception
{
    public function __construct(string $value)
    {
        $message = sprintf('`%s` is not a valid UUID.', $value);

        parent::__construct($message);
    }
}
