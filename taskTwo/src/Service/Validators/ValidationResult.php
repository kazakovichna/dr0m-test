<?php

namespace taskTwo\src\Service\Validators;

class ValidationResult
{
    /**
     * @var FieldValidationResult[]
     */
    private array $fieldValidationResults;

    public function __construct()
    {
        $this->fieldValidationResults = [];
    }

    public function addFieldValidationResult(string $fieldName, FieldValidationResult $fieldValidationResult): void
    {
        $this->fieldValidationResults[$fieldName] = $fieldValidationResult;
    }

    public function isValid(): bool
    {
        /** @var FieldValidationResult $fieldValidationResult */
        foreach ($this->fieldValidationResults as $fieldValidationResult) {
            if (!$fieldValidationResult->isValid()) {
                return false;
            }
        }

        return true;
    }

    public function getFieldValidationResults(): array
    {
        return $this->fieldValidationResults;
    }

    public function getFieldValidationResultsAsString(): string
    {
        return implode('; ', $this->fieldValidationResults);
    }
}