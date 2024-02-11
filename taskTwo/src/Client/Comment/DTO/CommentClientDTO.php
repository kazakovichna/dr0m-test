<?php

namespace taskTwo\src\Client\Comment\DTO;

class CommentClientDTO
{
    protected ?string $name;
    protected ?string $text;

    public function __construct(?string $name, $text)
    {
        $this->name = $name;
        $this->text = $text;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'text' => $this->text,
        ];
    }
}