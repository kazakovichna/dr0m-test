<?php

namespace taskTwo\src\Service\Validators;

class FieldValidationResult
{
    private bool $isValid;
    private array $errorMessages;

    public function __construct(bool $isValid, array $errorMessages)
    {
        $this->isValid = $isValid;
        $this->errorMessages = $errorMessages;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }
}