<?php

namespace taskTwo\src\Service\Validators\Comment;

use taskTwo\src\Service\Validators\FieldValidationResult;
use taskTwo\src\Service\Validators\ValidationResult;

class CommentClientDTOValidator
{
    /**
     * @var array
     */
    private array $validationRules = [
        'name' => 'required|string',
        'text' => 'required|string',
    ];


    /**
     * @param array $data
     *
     * @return ValidationResult
     */
    public function validate(array $data): ValidationResult
    {
        $validationResult = new ValidationResult();

        foreach ($this->validationRules as $field => $rules) {
            $fieldValue = $data[$field] ?? null;
            $fieldValidation = $this->validateField($fieldValue, $rules);

            $validationResult->addFieldValidationResult($field, $fieldValidation);
        }

        return $validationResult;
    }

    /**
     * @param mixed $value
     * @param string $rules
     *
     * @return FieldValidationResult
     */
    private function validateField(mixed $value, string $rules): FieldValidationResult
    {
        $valid = true;
        $errorMessages = [];

        $ruleList = explode('|', $rules);

        foreach ($ruleList as $rule) {
            if ($rule === 'required' && empty($value)) {
                $valid = false;
                $errorMessages[] = 'The field is required';
            }

            if ($rule === 'string' && !is_string($value) && !empty($value)) {
                $valid = false;
                $errorMessages[] = "Expected {$value} as string";
            }

        }

        return new FieldValidationResult($valid, $errorMessages);
    }

}