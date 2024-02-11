<?php

namespace taskTwo\src\Entity\Comment\DTO;

class CommentDTO
{
    protected int $id;
    protected ?string $name;
    protected ?string $text;

    public function __construct(int $id, ?string $name, $text)
    {
        $this->id   = $id;
        $this->name = $name;
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getText(): ?string
    {
        return $this->text;
    }
}