<?php

namespace taskTwo\src\Client\Comment;

use taskTwo\src\Client\Comment\DTO\CommentResponse;
use taskTwo\src\Entity\Comment\DTO\CommentDTO;
use taskTwo\src\Service\Comment\CommentService;
use taskTwo\src\Client\Comment\DTO\CommentClientDTO;

class CommentClient
{
    public CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @return CommentDTO[]
     */
    public function getComments(): array
    {
        return $this->commentService->getComments();
    }

    public function addComment(CommentClientDTO $comment): CommentResponse
    {
        return $this->commentService->addComment($comment);
    }

    public function updateComment(int $commentId, CommentClientDTO $comment): CommentResponse
    {
        return $this->commentService->updateComment($commentId, $comment);
    }
}