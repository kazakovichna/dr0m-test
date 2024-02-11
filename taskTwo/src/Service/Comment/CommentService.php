<?php

namespace taskTwo\src\Service\Comment;

use taskTwo\src\Client\Comment\DTO\CommentClientDTO;
use taskTwo\src\Client\Comment\DTO\CommentResponse;
use taskTwo\src\Entity\Comment\Comment;
use taskTwo\src\Entity\Comment\DTO\CommentDTO;
use taskTwo\src\Service\HttpService\Exception\HttpServiceException;
use taskTwo\src\Service\HttpService\HttpService;
use taskTwo\src\Service\Validators\Comment\CommentClientDTOValidator;

class CommentService
{
    public HttpService $httpService;
    public CommentClientDTOValidator $commentValidator;

    public function __construct(
        HttpService $httpService,
        CommentClientDTOValidator $commentValidator
    ) {
        $this->httpService = $httpService;
        $this->commentValidator = $commentValidator;
    }

    /**
     * @return CommentDTO[]
     */
    public function getComments(): array
    {
        try {
            $commentsResponseArray = $this->httpService->getComments();
        } catch (HttpServiceException $e) {
            $commentsResponseArray = [];
        }

        $comments = [];
        foreach ($commentsResponseArray as $comment) {
            $comments[] = new Comment(
                $comment['id'],
                $comment['name'],
                $comment['text'],
            );
        }

        return $this->serializeComments($comments);
    }

    public function addComment(CommentClientDTO $comment): CommentResponse
    {
        $validationResult = $this->commentValidator->validate($comment->toArray());
        if (!$validationResult->isValid()) {
            return new CommentResponse(
                false,
                $validationResult->getFieldValidationResultsAsString(),
                null
            );
        }

        try {
            $this->httpService->addComment($comment->toArray());
            return new CommentResponse(true, 'Comment successfully added', null);
        } catch (HttpServiceException $e) {
            return new CommentResponse(
                false, $e->getMessage(),
                null
            );
        }
    }

    public function updateComment(int $commentId, CommentClientDTO $comment): CommentResponse
    {
        $validationResult = $this->commentValidator->validate($comment->toArray());
        if (!$validationResult->isValid()) {
            return new CommentResponse(
                false,
                $validationResult->getFieldValidationResultsAsString(),
                null
            );
        }

        try {
            $this->httpService->updateComment($commentId, $comment->toArray());
            return new CommentResponse(true, 'Comment successfully changed', $commentId);
        } catch (HttpServiceException $e) {
            return new CommentResponse(
                false, $e->getMessage(),
                null
            );
        }
    }

    /**
     * @param Comment[] $comments
     *
     * @return CommentDTO[]
     */
    protected function serializeComments(array $comments): array
    {
        $serializedComments = [];

        foreach ($comments as $comment) {
            $serializedComments[] = new CommentDTO(
                $comment->getId(),
                $comment->getName(),
                $comment->getText(),
            );
        }

        return $serializedComments;
    }
}