<?php

namespace taskTwo\src\Entity\Comment;

class Comment
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

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

}