<?php

declare(strict_types=1);

namespace App\Exceptions;

final class QueryHandlerRegistrationException extends \Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function unexpectedClass(string $class): self
    {
        return new self(
            'Expected class implementing QueryHandler, got ' . $class
        );
    }

    public static function queryHandledAlready(string $class): self
    {
        return new self(sprintf(
            'Another handler is registered for "%s" Query already.',
            $class
        ));
    }

    public static function missingHandler(string $class): self
    {
        return new self(sprintf(
            'No handler registered for "%s" Query.',
            $class
        ));
    }
}
