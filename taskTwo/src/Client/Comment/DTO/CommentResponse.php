<?php

namespace taskTwo\src\Client\Comment\DTO;

class CommentResponse
{
    private bool $success;
    private string $message;
    private ?int $commentId;

    public function __construct(bool $success, string $message, ?int $commentId)
    {
        $this->success   = $success;
        $this->commentId = $commentId;
        $this->message   = $message;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getCommentId(): ?int
    {
        return $this->commentId;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

}