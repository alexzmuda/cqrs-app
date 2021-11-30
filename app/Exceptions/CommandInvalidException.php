<?php

namespace App\Exceptions;

use Throwable;

class CommandInvalidException extends \Exception
{
    public function __construct(string $className, string $actualClassName)
    {
        parent::__construct(sprintf(
            'Invalid command passed to handler. Expected %s, got %s',
            $className,
            $actualClassName
        ));
    }
}
