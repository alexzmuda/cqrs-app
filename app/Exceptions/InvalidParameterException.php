<?php

namespace App\Exceptions;

use Throwable;

class InvalidParameterException extends \Exception
{
    public const NULL_ON_NOT_NULLABLE = 'Provided parameter does not accept null as a value';

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
