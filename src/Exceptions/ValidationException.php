<?php

namespace BrowserUseLaravel\Exceptions;

class ValidationException extends BrowserUseException
{
    protected array $errors;

    public function __construct(string $message = '', int $statusCode = 422, array $errors = [], ?\Throwable $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
