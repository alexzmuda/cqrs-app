<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;

class QueryInvalidException extends \Exception
{
    public function __construct(string $className, string $actualClassName)
    {
        $message = sprintf(
            'Invalid query passed to handler. Expected %s, got %s',
            $className,
            $actualClassName
        );

        parent::__construct($message);
    }
}
