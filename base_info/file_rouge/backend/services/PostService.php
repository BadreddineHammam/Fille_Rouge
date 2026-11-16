<?php

require_once __DIR__ . "/../dao/PostDAO.php";
require_once __DIR__ . "/BaseService.php";

class PostService extends BaseService
{
    private PostDAO $postDAO;

    public function __construct(string $dataFile)
    {
        $this->postDAO = new PostDAO($dataFile);
    }

    public function listPosts(): array
    {
        $data = [];
        $posts = $this->postDAO->getAll();

        usort($posts, static function (Post $first, Post $second): int {
            return strcmp($second->getCreatedAt(), $first->getCreatedAt());
        });

        foreach ($posts as $post) {
            $data[] = $this->postToArray($post);
        }

        return $data;
    }

    public function createPost(string $author, string $role, string $content): array
    {
        $author = $this->validateText($author, "Le nom");
        $role = $this->validateText($role, "Le métier");
        $content = $this->validateText($content, "La publication");
        $this->validateLength($author, 80, "Le nom");
        $this->validateLength($role, 100, "Le métier");
        $this->validateLength($content, 1000, "La publication");

        return $this->postToArray($this->postDAO->create($author, $role, $content));
    }

    public function updatePost(int $id, string $author, string $role, string $content): array
    {
        $this->validateId($id);
        $author = $this->validateText($author, "Le nom");
        $role = $this->validateText($role, "Le métier");
        $content = $this->validateText($content, "La publication");
        $this->validateLength($author, 80, "Le nom");
        $this->validateLength($role, 100, "Le métier");
        $this->validateLength($content, 1000, "La publication");

        $post = $this->postDAO->update($id, $author, $role, $content);

        if ($post === null) {
            throw new OutOfBoundsException("Cette publication n'existe pas.");
        }

        return $this->postToArray($post);
    }

    public function deletePost(int $id): void
    {
        $this->validateId($id);

        if (!$this->postDAO->delete($id)) {
            throw new OutOfBoundsException("Cette publication n'existe pas.");
        }
    }

    private function validateText(string $value, string $field): string
    {
        $value = trim($value);

        if ($value === "") {
            throw new InvalidArgumentException($field . " est obligatoire.");
        }

        return $value;
    }

    private function validateLength(string $value, int $maximum, string $field): void
    {
        if (strlen($value) > $maximum) {
            throw new InvalidArgumentException($field . " dépasse la longueur maximale de " . $maximum . " caractères.");
        }
    }

    private function validateId(int $id): void
    {
        if ($id < 1) {
            throw new InvalidArgumentException("L'identifiant de la publication est invalide.");
        }
    }

    private function postToArray(Post $post): array
    {
        return [
            "id" => $post->getId(),
            "author" => $post->getAuthor(),
            "role" => $post->getRole(),
            "content" => $post->getContent(),
            "createdAt" => $post->getCreatedAt(),
        ];
    }
}
