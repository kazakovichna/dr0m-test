<?php

namespace taskTwo\tests;

use PHPUnit\Framework\TestCase;
use taskTwo\src\Service\Validators\Comment\CommentClientDTOValidator;

class CommentValidatorTest extends TestCase
{
    public function testValidationWithValidData()
    {
        $validator = new CommentClientDTOValidator();

        $data = [
            'name' => 'testName',
            'text' => 'testText',
        ];

        $result = $validator->validate($data);

        $this->assertTrue($result->isValid());
        $this->assertCount(2, $result->getFieldValidationResults());
    }

    public function testValidationWithMissingRequiredFields()
    {
        $validator = new CommentClientDTOValidator();

        $data = [
            'name' => 'testName'
        ];

        $result = $validator->validate($data);

        $this->assertFalse($result->isValid());

        $fieldValidationResults = $result->getFieldValidationResults();

        $this->assertCount(2, $fieldValidationResults);
        $this->assertFalse($fieldValidationResults['text']->isValid());
        $this->assertEquals(['The field is required'], $fieldValidationResults['text']->getErrorMessages());
    }

    public function testValidationWithStringTypeInvalid()
    {
        $validator = new CommentClientDTOValidator();

        $data = [
            'name' => 'John Doe',
            'text' => 1,
        ];

        $result = $validator->validate($data);

        $this->assertFalse($result->isValid());

        $fieldValidationResults = $result->getFieldValidationResults();

        $this->assertCount(2, $fieldValidationResults);
        $this->assertFalse($fieldValidationResults['text']->isValid());
        $this->assertEquals(['Expected 1 as string'], $fieldValidationResults['text']->getErrorMessages());
    }
}
