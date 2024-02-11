<?php

namespace taskTwo\tests;

use PHPUnit\Framework\TestCase;
use taskTwo\src\Client\Comment\DTO\CommentClientDTO;
use taskTwo\src\Client\Comment\DTO\CommentResponse;
use taskTwo\src\Entity\Comment\Comment;
use taskTwo\src\Entity\Comment\DTO\CommentDTO;
use taskTwo\src\Service\Comment\CommentService;
use taskTwo\src\Service\HttpService\Exception\HttpServiceException;
use taskTwo\src\Service\HttpService\HttpService;
use taskTwo\src\Service\Validators\Comment\CommentClientDTOValidator;
use taskTwo\src\Service\Validators\ValidationResult;

class CommentServiceTest extends TestCase
{
    protected CommentService $commentService;

    protected function setUp(): void
    {
        $httpServiceMock = $this->createMock(HttpService::class);
        $commentValidatorMock = $this->createMock(CommentClientDTOValidator::class);

        $this->commentService = new CommentService($httpServiceMock, $commentValidatorMock);
    }

    public function testGetCommentsCorrect()
    {
        $httpServiceMock = $this->createMock(HttpService::class);
        $httpServiceMock->expects($this->once())
            ->method('getComments')
            ->willReturn([
                [
                    "id" => 1,
                    "name" => "testName",
                    "text" => "testText",
                ]
            ]);

        $commentServiceMock = $this->getMockBuilder(CommentService::class)
            ->setConstructorArgs([$httpServiceMock, $this->createMock(CommentClientDTOValidator::class)])
            ->onlyMethods(['serializeComments'])
            ->getMock();

        $testComments = [new Comment(1, 'testName', 'testText')];

        $commentServiceMock->expects($this->once())
            ->method('serializeComments')
            ->with($this->equalTo($testComments))
            ->willReturn([new CommentDTO(1, 'testName', 'testText')]);

        $result = $commentServiceMock->getComments();

        $this->assertEquals([new CommentDTO(1, 'testName', 'testText')], $result);
    }

    public function testGetCommentsThrowsHttpServiceException()
    {
        $httpServiceMock = $this->createMock(HttpService::class);

        $httpServiceMock->expects($this->once())
            ->method('getComments')
            ->willThrowException(new HttpServiceException("HTTP Service Error"));

        $commentService = new CommentService($httpServiceMock, $this->createMock(CommentClientDTOValidator::class));

        $result = $commentService->getComments();

        $this->assertEquals([], $result);
    }

    public function testAddCommentCorrect()
    {
        $testCommentDTO = $this->createMock(CommentClientDTO::class);

        $testValidationResult = $this->createMock(ValidationResult::class);
        $testValidationResult->method('isValid')->willReturn(true);

        $this->commentService->commentValidator->expects($this->once())
            ->method('validate')
            ->willReturn($testValidationResult);

        $this->commentService->httpService->expects($this->once())
            ->method('addComment');

        $result = $this->commentService->addComment($testCommentDTO);

        $this->assertEquals(new CommentResponse(true, 'Comment successfully added', null), $result);
    }

    public function testAddCommentValidationFailure()
    {
        $testCommentDTO = $this->createMock(CommentClientDTO::class);
        $testValidationResult = $this->createMock(ValidationResult::class);
        $testValidationResult->method('isValid')->willReturn(false);
        $testValidationResult->method('getFieldValidationResultsAsString')->willReturn('Validation failed');

        $this->commentService->commentValidator->expects($this->once())
            ->method('validate')
            ->willReturn($testValidationResult);

        $result = $this->commentService->addComment($testCommentDTO);

        $this->assertEquals(new CommentResponse(false, 'Validation failed', null), $result);
    }

    public function testAddCommentsThrowsHttpServiceException()
    {
        $testCommentDTO = $this->createMock(CommentClientDTO::class);

        $testValidationResult = $this->createMock(ValidationResult::class);
        $testValidationResult->method('isValid')->willReturn(true);

        $this->commentService->commentValidator->expects($this->once())
            ->method('validate')
            ->willReturn($testValidationResult);

        $this->commentService->httpService->expects($this->once())
            ->method('addComment')
            ->willThrowException(new HttpServiceException("HTTP Service Error"));

        $result = $this->commentService->addComment($testCommentDTO);

        $this->assertEquals(new CommentResponse(false, "HTTP Service Error", null), $result);

    }

    public function testUpdateCommentCorrect()
    {
        $testCommentId = 1;
        $testCommentDTO = $this->createMock(CommentClientDTO::class);

        $testValidationResult = $this->createMock(ValidationResult::class);
        $testValidationResult->method('isValid')->willReturn(true);

        $this->commentService->commentValidator->expects($this->once())
            ->method('validate')
            ->willReturn($testValidationResult);

        $this->commentService->httpService->expects($this->once())
            ->method('updateComment');

        $result = $this->commentService->updateComment($testCommentId, $testCommentDTO);

        $this->assertEquals(new CommentResponse(true, 'Comment successfully changed', 1), $result);
    }

    public function testUpdateCommentThrowsHttpServiceException()
    {
        $testCommentId = 1;
        $testCommentDTO = $this->createMock(CommentClientDTO::class);

        $testValidationResult = $this->createMock(ValidationResult::class);
        $testValidationResult->method('isValid')->willReturn(true);

        $this->commentService->commentValidator->expects($this->once())
            ->method('validate')
            ->willReturn($testValidationResult);

        $this->commentService->httpService->expects($this->once())
            ->method('updateComment')
            ->willThrowException(new HttpServiceException("HTTP Service Error"));

        $result = $this->commentService->updateComment($testCommentId, $testCommentDTO);

        $this->assertEquals(new CommentResponse(false, "HTTP Service Error", null), $result);
    }
}