<?php

require_once __DIR__ . "/../classes/Post.php";

class PostDAO
{
    public function __construct(private string $dataFile)
    {
    }

    public function getAll(): array
    {
        $json = file_get_contents($this->dataFile);

        if ($json === false) {
            throw new RuntimeException("Le fichier des publications ne peut pas être lu.");
        }

        $data = json_decode($json, true);

        if (!is_array($data)) {
            throw new RuntimeException("Le fichier des publications ne contient pas une liste JSON valide.");
        }

        $posts = [];

        foreach ($data as $item) {
            if (
                !is_array($item)
                || !isset($item["id"], $item["author"], $item["role"], $item["content"], $item["createdAt"])
                || !is_int($item["id"])
                || !is_string($item["author"])
                || !is_string($item["role"])
                || !is_string($item["content"])
                || !is_string($item["createdAt"])
            ) {
                throw new RuntimeException("Une publication contient des données invalides.");
            }

            $posts[] = new Post(
                $item["id"],
                $item["author"],
                $item["role"],
                $item["content"],
                $item["createdAt"]
            );
        }

        return $posts;
    }

    public function create(string $author, string $role, string $content): Post
    {
        $posts = $this->getAll();
        $ids = [];

        foreach ($posts as $post) {
            $ids[] = $post->getId();
        }

        $newPost = new Post(
            $ids === [] ? 1 : max($ids) + 1,
            $author,
            $role,
            $content,
            date(DATE_ATOM)
        );
        $posts[] = $newPost;

        $this->saveAll($posts);

        return $newPost;
    }

    public function update(int $id, string $author, string $role, string $content): ?Post
    {
        $posts = $this->getAll();
        $updatedPost = null;
        $updatedPosts = [];

        foreach ($posts as $post) {
            if ($post->getId() === $id) {
                $post = new Post(
                    $id,
                    $author,
                    $role,
                    $content,
                    $post->getCreatedAt()
                );
                $updatedPost = $post;
            }

            $updatedPosts[] = $post;
        }

        if ($updatedPost !== null) {
            $this->saveAll($updatedPosts);
        }

        return $updatedPost;
    }

    public function delete(int $id): bool
    {
        $posts = $this->getAll();
        $remainingPosts = [];
        $wasDeleted = false;

        foreach ($posts as $post) {
            if ($post->getId() === $id) {
                $wasDeleted = true;
                continue;
            }

            $remainingPosts[] = $post;
        }

        if ($wasDeleted) {
            $this->saveAll($remainingPosts);
        }

        return $wasDeleted;
    }

    private function saveAll(array $posts): void
    {
        $data = [];

        foreach ($posts as $post) {
            $data[] = [
                "id" => $post->getId(),
                "author" => $post->getAuthor(),
                "role" => $post->getRole(),
                "content" => $post->getContent(),
                "createdAt" => $post->getCreatedAt(),
            ];
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($json === false || file_put_contents($this->dataFile, $json, LOCK_EX) === false) {
            throw new RuntimeException("Les publications ne peuvent pas être enregistrées.");
        }
    }
}
