<?php

namespace App\Infrastructure\Exceptions;

class InvalidFormRequestException extends \Exception
{
    public function __construct(string $required, string $provided)
    {
        $message = sprintf('%s instance required, %s provided', $required, $provided);

        parent::__construct($message);
    }
}
