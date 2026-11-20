<?php

class Post
{
    public function __construct(
        private int $id,
        private string $author,
        private string $role,
        private string $content,
        private string $createdAt,
        private ?int $userId = null
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }
}
