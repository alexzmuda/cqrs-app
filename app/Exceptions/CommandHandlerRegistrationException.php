<?php

declare(strict_types=1);

namespace App\Exceptions;

final class CommandHandlerRegistrationException extends \Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function unexpectedClass(string $class): self
    {
        return new self(
            'Expected class implementing CommandHandler, got ' . $class
        );
    }

    public static function commandHandledAlready(string $class): self
    {
        return new self(sprintf(
            'Another handler is registered for "%s" Command already.',
            $class
        ));
    }

    public static function missingHandler(string $class): self
    {
        return new self(sprintf(
            'No handler registered for "%s" Command.',
            $class
        ));
    }
}
