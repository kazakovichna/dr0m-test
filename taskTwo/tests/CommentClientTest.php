<?php

namespace taskTwo\tests;

use PHPUnit\Framework\TestCase;
use taskTwo\src\Client\Comment\CommentClient;
use taskTwo\src\Client\Comment\DTO\CommentClientDTO;
use taskTwo\src\Client\Comment\DTO\CommentResponse;
use taskTwo\src\Entity\Comment\DTO\CommentDTO;
use taskTwo\src\Service\Comment\CommentService;

class CommentClientTest extends TestCase
{

    protected CommentClient $commentClient;

    protected function setUp(): void
    {
        $commentServiceMock = $this->createMock(CommentService::class);
        $this->commentClient = new CommentClient($commentServiceMock);
    }

    public function testGetCommentsCorrect()
    {
        $testComments = [
            1 => new CommentDTO(1, "testName", "testText"),
            2 => new CommentDTO(2, "testName", "testText"),
        ];
        $this->commentClient->commentService->expects($this->once())
            ->method('getComments')
            ->willReturn($testComments);

        $result = $this->commentClient->getComments();

        $this->assertEquals($testComments, $result);
    }

    public function testGetCommentsReturnType()
    {
        $result = $this->commentClient->getComments();
        $this->assertIsArray($result);
    }

    public function testAddCommentCorrect()
    {
        $testCommentDTO = new CommentClientDTO('testName', 'testText');
        $testResponse = new CommentResponse(true, "Comment successfully added", null);
        $this->commentClient->commentService->expects($this->once())
            ->method('addComment')
            ->with($testCommentDTO)
            ->willReturn($testResponse);

        $result = $this->commentClient->addComment($testCommentDTO);

        $this->assertEquals($testResponse, $result);
    }

    public function testAddCommentValidationError()
    {
        $testCommentDTO = new CommentClientDTO('testName', null);
        $testResponse = new CommentResponse(false, 'The field is required', null);
        $this->commentClient->commentService->expects($this->once())
            ->method('addComment')
            ->with($testCommentDTO)
            ->willReturn($testResponse);

        $result = $this->commentClient->AddComment($testCommentDTO);

        $this->assertEquals($testResponse, $result);
    }

    public function testUpdateCommentCorrect()
    {
        $commentId = 1;
        $testCommentDTO = new CommentClientDTO('testName', 'testText');
        $testResponse = new CommentResponse(true, 'Comment successfully changed', 1);
        $this->commentClient->commentService->expects($this->once())
            ->method('updateComment')
            ->with($commentId, $testCommentDTO)
            ->willReturn($testResponse);

        $result = $this->commentClient->updateComment($commentId, $testCommentDTO);

        $this->assertEquals($testResponse, $result);
    }

    public function testUpdateCommentValidationError()
    {
        $commentId = 1;
        $testCommentDTO = new CommentClientDTO('testName', null);
        $testResponse = new CommentResponse(false, 'The field is required', null);
        $this->commentClient->commentService->expects($this->once())
            ->method('updateComment')
            ->with($commentId, $testCommentDTO)
            ->willReturn($testResponse);

        $result = $this->commentClient->updateComment($commentId, $testCommentDTO);

        $this->assertEquals($testResponse, $result);
    }
}