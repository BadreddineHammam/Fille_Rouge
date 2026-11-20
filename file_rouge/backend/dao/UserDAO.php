<?php

class UserDAO
{
    public function __construct(private string $dataFile)
    {
    }

    public function getAll(): array
    {
        $json = file_get_contents($this->dataFile);

        if ($json === false) {
            throw new RuntimeException("Le fichier des utilisateurs ne peut pas être lu.");
        }

        $data = json_decode($json, true);

        if (!is_array($data)) {
            throw new RuntimeException("Le fichier des utilisateurs ne contient pas une liste JSON valide.");
        }

        foreach ($data as $user) {
            if (
                !is_array($user)
                || !isset($user["id"], $user["name"], $user["email"], $user["role"], $user["passwordHash"])
                || !is_int($user["id"])
                || !is_string($user["name"])
                || !is_string($user["email"])
                || !in_array($user["role"], ["user", "admin"], true)
                || !is_string($user["passwordHash"])
            ) {
                throw new RuntimeException("Un utilisateur contient des données invalides.");
            }
        }

        return $data;
    }

    public function findByEmail(string $email): ?array
    {
        foreach ($this->getAll() as $user) {
            if ($user["email"] === $email) {
                return $user;
            }
        }

        return null;
    }

    public function findById(int $id): ?array
    {
        foreach ($this->getAll() as $user) {
            if ($user["id"] === $id) {
                return $user;
            }
        }

        return null;
    }

    public function create(string $name, string $email, string $passwordHash, string $role): array
    {
        $users = $this->getAll();

        foreach ($users as $user) {
            if ($user["email"] === $email) {
                throw new InvalidArgumentException("Un compte avec cette adresse e-mail existe déjà.");
            }
        }

        $ids = [];

        foreach ($users as $user) {
            $ids[] = $user["id"];
        }

        $user = [
            "id" => $ids === [] ? 1 : max($ids) + 1,
            "name" => $name,
            "email" => $email,
            "role" => $role,
            "passwordHash" => $passwordHash,
            "createdAt" => date(DATE_ATOM),
        ];
        $users[] = $user;
        $this->saveAll($users);

        return $user;
    }

    private function saveAll(array $users): void
    {
        $json = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($json === false || file_put_contents($this->dataFile, $json, LOCK_EX) === false) {
            throw new RuntimeException("Les utilisateurs ne peuvent pas être enregistrés.");
        }
    }
}
